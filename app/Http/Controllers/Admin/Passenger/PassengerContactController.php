<?php

namespace AgenciaS3\Http\Controllers\Admin\Passenger;

use AgenciaS3\Criteria\FindByFromToCreatedAtCriteria;
use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\AdminRequest;
use AgenciaS3\Repositories\PassengerContactRepository;
use AgenciaS3\Validators\PassengerContactValidator;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;


class PassengerContactController extends Controller
{

    protected $repository;

    protected $validator;

    public function __construct(PassengerContactRepository $repository, PassengerContactValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function index(Request $request)
    {
        $from = $request->get('from');
        $to = $request->get('to');
        if (isset($from) || isset($to)) {
            $this->repository->pushCriteria(new FindByFromToCreatedAtCriteria($request->get('from'), $request->get('to')));
        } else {
            $this->repository->skipCriteria();
        }

        $config = $this->header();
        $dados = $this->repository->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.passenger-contact.index', compact('dados', 'config'));
    }

    public function header()
    {
        $config['title'] = "Cadastrados";
        $config['activeMenu'] = 'passenger';
        $config['activeMenuN2'] = 'contact';
        $config['route']['queryString'] = '';
        $getQueryString = request()->getQueryString();
        if (isset($getQueryString)) {
            $config['route']['queryString'] = '?' . request()->getQueryString();
        }

        return $config;
    }

    public function show($id)
    {
        $config = $this->header();
        $config['action'] = 'Visualizar';

        $dados = $this->repository->find($id);

        if ($dados['view'] == 'n') {
            $this->updateView($dados, 'y');
        }

        return view('admin.passenger-contact.show', compact('dados', 'config'));
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

    public function update(AdminRequest $request, $id)
    {
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $contact = $this->repository->update($id, $request->all());

            $response = [
                'message' => 'Contact updated.',
                'data' => $contact->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);
        return redirect()->back()->with('success', 'Registro excluído com sucesso!');
    }

    public function export(Request $request)
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
        header("Content-Disposition: attachment; filename=\"Passageiros_Cadastrados_" . date('Ymds') . ".csv\"");

        $listar = $this->repository->all();

        $campos = "Nome;";
        $campos .= "RG;";
        $campos .= "CPF;";
        $campos .= "CEP;";
        $campos .= "Logradouro;";
        $campos .= "Número;";
        $campos .= "Complemento;";
        $campos .= "Estado;";
        $campos .= "Cidade;";
        $campos .= "Telefone;";
        $campos .= "Telefone 2;";
        $campos .= "Valor desejado;";
        $campos .= "Visualizado;";
        $campos .= "Data;";
        $campos .= "\n";

        print utf8_decode($campos);
        foreach ($listar as $dados) {

            $view = 'Não';
            if ($dados->view == 'y') {
                $view = 'Sim';
            }

            $item = '"';
            $item .= utf8_decode($dados->name) . '";"';
            $item .= utf8_decode($dados->rg) . '";"';
            $item .= utf8_decode($dados->cpf) . '";"';
            $item .= utf8_decode($dados->zip_code) . '";"';
            $item .= utf8_decode($dados->address) . '";"';
            $item .= utf8_decode($dados->number) . '";"';
            $item .= utf8_decode($dados->complement) . '";"';
            $item .= utf8_decode($dados->state) . '";"';
            $item .= utf8_decode($dados->city) . '";"';
            $item .= utf8_decode($dados->phone) . '";"';
            $item .= utf8_decode($dados->phone_2) . '";"';
            $item .= utf8_decode($dados->price) . '";"';
            $item .= utf8_decode($view) . '";"';
            $item .= utf8_decode(date('d/m/Y h:i', strtotime($dados->created_at))) . '";';
            $item .= "\r\n";

            echo $item;
        }
        exit;
    }

    public function listHeader()
    {
        $dados = $this->repository->findWhere(['view' => 'n']);
        return $dados;
    }

}
