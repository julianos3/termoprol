<?php

namespace AgenciaS3\Http\Controllers\Admin\LandingPage;

use AgenciaS3\Criteria\FindByFromToCreatedAtCriteria;
use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\AdminRequest;
use AgenciaS3\Repositories\LandingPageContactRepository;
use AgenciaS3\Services\UtilObjeto;
use AgenciaS3\Validators\LandingPageContactValidator;
use Prettus\Validator\Exceptions\ValidatorException;


class LandingPageContactController extends Controller
{

    protected $repository;

    protected $validator;

    protected $utilObjeto;

    public function __construct(LandingPageContactRepository $repository,
                                LandingPageContactValidator $validator,
                                UtilObjeto $utilObjeto)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->utilObjeto = $utilObjeto;
    }

    public function index(AdminRequest $request, $landing_page_id)
    {
        $from = $request->get('from');
        $to = $request->get('to');
        if (isset($from) || isset($to)) {
            $this->repository->pushCriteria(new FindByFromToCreatedAtCriteria($request->get('from'), $request->get('to')));
        } else {
            $this->repository->skipCriteria();
        }

        $config = $this->header();
        $dados = $this->repository->orderBy('created_at', 'desc')->scopeQuery(function ($query) use ($landing_page_id) {
            return $query->where('landing_page_id', $landing_page_id);
        })->paginate();

        return view('admin.landing-page.contact.index', compact('dados', 'config', 'landing_page_id'));
    }

    public function all(AdminRequest $request)
    {
        $from = $request->get('from');
        $to = $request->get('to');
        if (isset($from) || isset($to)) {
            $this->repository->pushCriteria(new FindByFromToCreatedAtCriteria($request->get('from'), $request->get('to')));
        } else {
            $this->repository->skipCriteria();
        }

        $config = $this->header();
        $config['title'] = "Landing Page > Todos os contatos";
        $config['activeMenuN2'] = "contact";
        $dados = $this->repository->orderBy('created_at', 'desc')->paginate();

        return view('admin.landing-page.contact.all', compact('dados', 'config', 'landing_page_id'));
    }

    public function header()
    {
        $config['title'] = "Landing Page > Contatos";
        $config['activeMenu'] = "landing-page";
        $config['activeMenuN2'] = "landing-page";

        return $config;
    }

    public function show($id)
    {
        $config = $this->header();
        $config['action'] = 'Editar';
        $dados = $this->repository->find($id);
        $landing_page_id = $dados->landing_page_id;

        if ($dados['view'] == 'n') {
            $this->updateView($dados, 'y');
        }

        return view('admin.landing-page.contact.show', compact('dados', 'config', 'landing_page_id'));
    }

    public function updateView($dados, $view)
    {
        try {
            $data = $dados->toArray();
            $data['view'] = $view;

            $contact = $this->repository->update($data, $dados->id);

            return $contact;

        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    public function export(AdminRequest $request, $landing_page_id)
    {
        $from = $request->get('from');
        $to = $request->get('to');
        if (isset($from) || isset($to)) {
            $this->repository->pushCriteria(new FindByFromToCreatedAtCriteria($request->get('from'), $request->get('to')));
        } else {
            $this->repository->skipCriteria();
        }

        header("Pragma: no-cache");
        header("Expires: 0");
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"Landing_Page_Contato_" . date('Ymds') . ".csv\"");

        $listar = $dados = $this->repository->orderBy('created_at', 'desc')->findByField('landing_page_id', $landing_page_id);

        $campos = "Landing Page;";
        $campos .= "Nome;";
        $campos .= "Telefone;";
        $campos .= "E-mail;";
        $campos .= "Visualizado;";
        $campos .= "Mensagem;";
        $campos .= "Data;";
        $campos .= "\n";

        print utf8_decode($campos);
        foreach ($listar as $dados) {

            $view = 'Não';
            if ($dados->view == 'y') {
                $view = 'Sim';
            }

            $type = '';
            if (isset($dados->profile->name)) {
                $type = $dados->profile->name;
            }

            $item = '"';
            $item .= utf8_decode($dados->landingPage->name) . '";"';
            $item .= utf8_decode($dados->name) . '";"';
            $item .= utf8_decode($dados->email) . '";"';
            $item .= utf8_decode($dados->phone) . '";"';
            $item .= utf8_decode($view) . '";"';
            $item .= utf8_decode($dados->message) . '";"';
            $item .= utf8_decode(date('d/m/Y h:i', strtotime($dados->created_at))) . '";';
            $item .= "\r\n";

            echo $item;
        }
        exit;
    }

}
