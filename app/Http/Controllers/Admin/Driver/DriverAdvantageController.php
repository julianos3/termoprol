<?php

namespace AgenciaS3\Http\Controllers\Admin\Driver;

use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\AdminRequest;
use AgenciaS3\Repositories\DriverAdvantageRepository;
use AgenciaS3\Services\UtilObjeto;
use AgenciaS3\Validators\DriverAdvantageValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;


class DriverAdvantageController extends Controller
{

    protected $repository;

    protected $validator;

    protected $utilObjeto;

    protected $path;

    public function __construct(DriverAdvantageRepository $repository,
                                DriverAdvantageValidator $validator,
                                UtilObjeto $utilObjeto)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->utilObjeto = $utilObjeto;
        $this->path = 'uploads/driver-advantage/';
    }

    public function index()
    {
        $config = $this->header();
        $dados = $this->repository->orderBy('order', 'asc')->paginate();

        return view('admin.driver-advantage.index', compact('dados', 'config'));
    }

    public function header()
    {
        $config['title'] = "Vantagem Motorista";
        $config['activeMenu'] = "driver";
        $config['activeMenuN2'] = "advantage";

        return $config;
    }

    public function create()
    {
        $config = $this->header();
        $config['action'] = 'Cadastrar';

        return view('admin.driver-advantage.create', compact('config'));
    }

    public function store(AdminRequest $request)
    {
        try {
            $data = $request->all();
            if (isset($data['icon'])) {
                $data['icon'] = $this->uploadIcon($request, $data);
            }

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

            if (isset($data['icon'])) {
                $this->utilObjeto->destroyFile($this->path, $data['icon']);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    public function uploadIcon($request, $data)
    {
        if (isset($data['icon'])) {
            $this->validate($request, [
                'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imageName = md5(time()) . '.' . $data['icon']->getClientOriginalExtension();
            $request->icon->move(public_path($this->path), $imageName);
            $data['icon'] = $imageName;

            return $data['icon'];
        }

        return null;
    }

    public function edit($id)
    {
        $config = $this->header();
        $config['action'] = 'Editar';
        $dados = $this->repository->find($id);

        return view('admin.driver-advantage.edit', compact('dados', 'config'));
    }

    public function update(AdminRequest $request, $id)
    {
        try {
            $data = $request->all();
            if (isset($data['icon'])) {
                $data['icon'] = $this->uploadIcon($request, $data);
            }

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
        $this->destroyIcon($id);
        $deleted = $this->repository->delete($id);
        return redirect()->back()->with('success', 'Registro removido com sucesso!');
    }

    public function destroyIcon($id)
    {
        $dados = $this->repository->find($id);
        if (isset($dados->icon)) {
            $data = $dados->toArray();
            if (isset($dados->icon) && $this->utilObjeto->destroyFile($this->path, $dados->icon)) {

                $data['icon'] = '';
                $this->repository->update($data, $id);

                return redirect()->back()->with('success', 'Ícon removido com sucesso!');
            }

            return redirect()->back()->withErrors('Erro ao excluír Ícon')->withInput();
        }
    }

}
