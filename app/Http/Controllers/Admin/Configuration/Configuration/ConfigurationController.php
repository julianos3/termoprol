<?php

namespace AgenciaS3\Http\Controllers\Admin\Configuration\Configuration;

use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\AdminRequest;
use AgenciaS3\Repositories\ConfigurationRepository;
use AgenciaS3\Validators\ConfigurationValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class ConfigurationController extends Controller
{

    protected $repository;

    protected $validator;

    public function __construct(ConfigurationRepository $repository,
                                ConfigurationValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function header()
    {
        $config['title'] = 'Configurações';
        $config['activeMenu'] = 'configuration';
        $config['activeMenuN2'] = 'configuration';

        return $config;
    }

    public function index()
    {
        $config = $this->header();
        $dados = $this->repository->orderBy('order', 'asc')->paginate();

        return view('admin.configuration.configuration.index', compact('dados', 'config'));
    }

    public function create()
    {
        $config = $this->header();
        $config['action'] = 'Cadastrar';

        return view('admin.configuration.configuration.create', compact('config'));
    }

    public function store(AdminRequest $request)
    {
        try {
            $data = $request->all();

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
            $dados = $this->repository->create($data);

            $response = [
                'success' => 'Registro atualizado com sucesso!',
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
        $config['action'] = 'Alterar';
        $dados = $this->repository->find($id);

        return view('admin.configuration.configuration.edit', compact('dados', 'config'));
    }

    public function update(AdminRequest $request, $id)
    {
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $configuration = $this->repository->update($request->all(), $id);

            $response = [
                'success' => 'Registro atualizado com sucesso!',
                'data' => $configuration->toArray(),
            ];

            return redirect()->back()->with('success', $response['success']);

        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);
        return redirect()->back()->with('success', 'Registro removido com sucesso!');
    }

}
