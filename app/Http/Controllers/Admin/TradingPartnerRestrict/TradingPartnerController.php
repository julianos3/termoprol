<?php

namespace AgenciaS3\Http\Controllers\Admin\TradingPartnerRestrict;

use AgenciaS3\Entities\Form;
use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\AdminRequest;
use AgenciaS3\Mail\TradingPartnerRestrict\TradingPartner\TradingPartnerCreatedMail;
use AgenciaS3\Repositories\TradingPartnerRepository;
use AgenciaS3\Services\UtilObjeto;
use AgenciaS3\Validators\TradingPartnerValidator;
use Illuminate\Support\Facades\Mail;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class TradingPartnerController extends Controller
{

    protected $repository;

    protected $validator;

    protected $realEstateRepository;

    public function __construct(TradingPartnerRepository $repository,
                                TradingPartnerValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function index()
    {
        $config = $this->header();
        $dados = $this->repository->paginate();

        return view('admin.trading-partner-restrict.trading-partner.index', compact('dados', 'config'));
    }

    public function header()
    {
        $config['title'] = "Sócio Operador";
        $config['activeMenu'] = "trading-partner-restrict";
        $config['activeMenuN2'] = "trading-partner";

        return $config;
    }

    public function create()
    {
        $config = $this->header();
        $config['action'] = 'Cadastrar';

        return view('admin.trading-partner-restrict.trading-partner.create', compact('config'));
    }

    public function store(AdminRequest $request)
    {
        try {
            $data = $request->all();

            $utilObjeto = new UtilObjeto();
            $data['password'] = $utilObjeto->geraSenha();
            $passwordCreated = $data['password'];
            $data['password_confirmation'] = $data['password'];

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
            $data['password'] = bcrypt($data['password']);
            $data['password_confirmation'] = $data['password'];

            $dados = $this->repository->create($data);

            //ENVIAR EMAIL COM OS ACESSOS PARA O CORRETOR
            $form = Form::find(5);
            Mail::to($dados)->send(new TradingPartnerCreatedMail($dados, $form, $passwordCreated));

            $response = [
                'success' => 'Sócio Operador adicionado com sucesso!',
                'data' => $dados->toArray(),
            ];

            return redirect()->back()->with('success', $response['success']);

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

    public function edit($id)
    {
        $config = $this->header();
        $config['action'] = 'Editar';
        $dados = $this->repository->find($id);

        return view('admin.trading-partner-restrict.trading-partner.edit', compact('dados', 'config'));
    }

    public function update(AdminRequest $request, $id)
    {
        try {
            $data = $request->all();
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $dados = $this->repository->update($data, $id);

            $response = [
                'success' => 'Registro atualizado com sucesso!',
                'data' => $dados->toArray(),
            ];

            return redirect()->back()->with('success', $response['success']);

        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    public function active($id)
    {
        try {
            $dados = $this->repository->find($id);
            $data = $dados->toArray();
            if ($dados->active == 'y') {
                $data['active'] = 'n';
            } else {
                $data['active'] = 'y';
            }

            $dados = $this->repository->update($data, $id);

            return $dados;

        } catch (ValidatorException $e) {
            return false;
        }
    }

    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);
        return redirect()->back()->with('success', 'Registro removido com sucesso!');
    }

}
