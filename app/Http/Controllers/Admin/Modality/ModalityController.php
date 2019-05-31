<?php

namespace AgenciaS3\Http\Controllers\Admin\Modality;

use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\AdminRequest;
use AgenciaS3\Repositories\ModalityRepository;
use AgenciaS3\Repositories\ServiceRepository;
use AgenciaS3\Services\UtilObjeto;
use AgenciaS3\Validators\ModalityValidator;
use AgenciaS3\Validators\ServiceValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;


class ModalityController extends Controller
{

    protected $repository;

    protected $validator;

    protected $utilObjeto;

    protected $path;

    public function __construct(ModalityRepository $repository,
                                ModalityValidator $validator,
                                UtilObjeto $utilObjeto)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->utilObjeto = $utilObjeto;
        $this->path = 'uploads/modality/';
    }

    public function index()
    {
        $config = $this->header();
        $dados = $this->repository->orderBy('order', 'asc')->paginate();

        return view('admin.modality.index', compact('dados', 'config'));
    }

    public function header()
    {
        $config['title'] = "Modalidade";
        $config['activeMenu'] = "modality";
        $config['activeMenuN2'] = "modality";

        return $config;
    }

    public function create()
    {
        $config = $this->header();
        $config['action'] = 'Cadastrar';

        return view('admin.modality.create', compact('config'));
    }

    public function store(AdminRequest $request)
    {
        try {
            $data = $request->all();
            $data['seo_link'] = $this->utilObjeto->nameUrl($data['name']);
            if(isset($data['image'])) {
                $data['image'] = $this->uploadImage($request, $data);
            }
            if(isset($data['icon'])) {
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

            if(isset($data['icon'])){
                $this->utilObjeto->destroyFile($this->path, $data['icon']);
            }
            if(isset($data['image'])){
                $this->utilObjeto->destroyFile($this->path, $data['image']);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    public function uploadImage($request, $data)
    {
        if (isset($data['image'])) {
            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imageName = md5(time()) . '.' . $data['image']->getClientOriginalExtension();
            $request->image->move(public_path($this->path), $imageName);
            $data['image'] = $imageName;

            return $data['image'];
        }

        return null;
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

        return view('admin.modality.edit', compact('dados', 'config'));
    }

    public function update(AdminRequest $request, $id)
    {
        try {
            $data = $request->all();
            $data['seo_link'] = $this->utilObjeto->nameUrl($data['name']);
            if(isset($data['image'])) {
                $data['image'] = $this->uploadImage($request, $data);
            }
            if(isset($data['icon'])) {
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
        $this->destroyImage($id);
        $this->destroyIcon($id);
        $deleted = $this->repository->delete($id);
        return redirect()->back()->with('success', 'Registro removido com sucesso!');
    }

    public function destroyImage($id)
    {
        $dados = $this->repository->find($id);
        if (isset($dados->image)) {
            $data = $dados->toArray();
            if (isset($dados->image) && $this->utilObjeto->destroyFile($this->path, $dados->image)) {

                $data['image'] = '';
                $this->repository->update($data, $id);

                return redirect()->back()->with('success', 'Imagem removida com sucesso!');
            }

            return redirect()->back()->withErrors('Erro ao excluír Imagem')->withInput();
        }
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
