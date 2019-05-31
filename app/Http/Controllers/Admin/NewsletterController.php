<?php

namespace AgenciaS3\Http\Controllers\Admin;

use AgenciaS3\Criteria\FindByFromToCreatedAtCriteria;
use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Repositories\NewsletterRepository;
use AgenciaS3\Validators\NewsletterValidator;
use Illuminate\Http\Request;


class NewsletterController extends Controller
{

    protected $repository;

    protected $validator;

    public function __construct(NewsletterRepository $repository, NewsletterValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function index(Request $request)
    {
        $from = $request->get('from');
        $to = $request->get('to');
        if (isset($from) || isset($to)){
            $this->repository->pushCriteria(new FindByFromToCreatedAtCriteria($request->get('from'), $request->get('to')));
        } else {
            $this->repository->skipCriteria();
        }

        $config = $this->header();

        $dados = $this->repository->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.newsletter.index', compact('dados', 'config'));
    }


    public function header()
    {
        $config['title'] = "Newsletter";
        $config['activeMenu'] = 'form';
        $config['activeMenuN2'] = 'newsletter';
        $config['route']['queryString'] = '';
        $getQueryString = request()->getQueryString();
        if (isset($getQueryString)) {
            $config['route']['queryString'] = '?' . request()->getQueryString();
        }

        return $config;
    }

    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Registro excluído com sucesso!',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('success', 'Registro excluído com sucesso!');
    }


    public function export(Request $request)
    {
        $from = $request->get('from');
        $to = $request->get('to');
        if (isset($from) || isset($to)){
            $this->repository->pushCriteria(new FindByFromToCreatedAtCriteria($request->get('from'), $request->get('to')));
        } else {
            $this->repository->skipCriteria();
        }

        header("Pragma: no-cache");
        header("Expires: 0");
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"Newsletter_".date('Ymds').".csv\"");

        $listar = $this->repository->all();

        $campos = "Nome;";
        $campos .= "E-mail;";
        $campos .= "Data;";
        $campos .= "\n";

        print utf8_decode($campos);
        foreach($listar as $dados){

            $item = '"';
            $item .= utf8_decode($dados->name).'";"';
            $item .= utf8_decode($dados->email).'";"';
            $item .= utf8_decode(date('d/m/Y h:i', strtotime($dados->created_at))).'";';
            $item .= "\r\n";

            echo $item;
        }
        exit;
    }

}
