<?php

namespace AgenciaS3\Http\Controllers\Admin\Service;

use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\AdminRequest;
use AgenciaS3\Repositories\ServiceProcessRepository;
use AgenciaS3\Validators\ServiceProcessValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;


class ServiceProcessController extends Controller
{

    protected $repository;

    protected $validator;

    public function __construct(ServiceProcessRepository $repository,
                                ServiceProcessValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function index($service_id)
    {
        $config = $this->header();
        $dados = $this->repository->orderBy('order', 'asc')->findByField('service_id', $service_id);

        return view('admin.service.process.index', compact('dados', 'config', 'service_id'));
    }

    public function header()
    {
        $config['title'] = "Serviços > Processos";
        $config['activeMenu'] = "service";
        $config['activeMenuN2'] = "service";

        return $config;
    }

    public function create($service_id)
    {
        $config = $this->header();
        $config['action'] = 'Cadastrar';

        return view('admin.service.process.create', compact('config', 'service_id'));
    }

    public function store(AdminRequest $request)
    {
        try {
            $data = $request->all();
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
            $dados = $this->repository->create($data);

            $response = [
                'success' => 'Registro adicionado com sucesso!',
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
        $service_id = $dados->service_id;

        return view('admin.service.process.edit', compact('dados', 'config', 'service_id'));
    }

    public function update(AdminRequest $request, $id)
    {
        try {
            $data = $request->all();
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $dados = $this->repository->update($data, $id);

            $response = [
                'success' => 'Registro alterado com sucesso!',
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
