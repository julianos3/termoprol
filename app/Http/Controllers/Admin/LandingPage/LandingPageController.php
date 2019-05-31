<?php

namespace AgenciaS3\Http\Controllers\Admin\LandingPage;

use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\AdminRequest;
use AgenciaS3\Repositories\LandingPageRepository;
use AgenciaS3\Services\UtilObjeto;
use AgenciaS3\Validators\LandingPageValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;


class LandingPageController extends Controller
{

    protected $repository;

    protected $validator;

    protected $utilObjeto;

    protected $path;

    public function __construct(LandingPageRepository $repository,
                                LandingPageValidator $validator,
                                UtilObjeto $utilObjeto)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->utilObjeto = $utilObjeto;
        $this->path = 'uploads/landing-page/';
    }

    public function index()
    {
        $config = $this->header();
        $dados = $this->repository->orderBy('name', 'asc')->paginate();

        return view('admin.landing-page.index', compact('dados', 'config'));
    }

    public function header()
    {
        $config['title'] = "Landing Page";
        $config['activeMenu'] = "landing-page";
        $config['activeMenuN2'] = "landing-page";

        return $config;
    }

    public function create()
    {
        $config = $this->header();
        $config['action'] = 'Cadastrar';

        return view('admin.landing-page.create', compact('config'));
    }

    public function store(AdminRequest $request)
    {
        try {
            $data = $request->all();
            $data['seo_link'] = $this->utilObjeto->nameUrl($data['name']);
            if (isset($data['banner'])) {
                $data['banner'] = $this->utilObjeto->uploadFile($request, $data, $this->path, 'banner', 'image|mimes:jpeg,png,jpg,gif,svg|max:2048');
            }
            if (isset($data['avatar_1_6'])) {
                $data['avatar_1_6'] = $this->utilObjeto->uploadFile($request, $data, $this->path, 'avatar_1_6', 'image|mimes:jpeg,png,jpg,gif,svg|max:2048');
            }
            if (isset($data['avatar_1_1'])) {
                $data['avatar_1_1'] = $this->utilObjeto->uploadFile($request, $data, $this->path, 'avatar_1_1', 'image|mimes:jpeg,png,jpg,gif,svg|max:2048');
            }

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
            $dados = $this->repository->create($data);

            $response = [
                'success' => 'Registro adicionado com sucesso!',
                'data' => $dados->toArray(),
            ];

            return redirect()->back()->with('success', $response['success']);

        } catch (ValidatorException $e) {
            if (isset($data['banner'])) {
                $this->utilObjeto->destroyFile($this->path, $data['banner']);
            }
            if (isset($data['avatar_1_6'])) {
                $this->utilObjeto->destroyFile($this->path, $data['avatar_1_6']);
            }
            if (isset($data['avatar_1_1'])) {
                $this->utilObjeto->destroyFile($this->path, $data['avatar_1_1']);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    public function edit($id)
    {
        $config = $this->header();
        $config['action'] = 'Editar';
        $dados = $this->repository->find($id);

        return view('admin.landing-page.edit', compact('dados', 'config'));
    }

    public function update(AdminRequest $request, $id)
    {
        try {
            $data = $request->all();
            $data['seo_link'] = $this->utilObjeto->nameUrl($data['name']);
            if (isset($data['banner'])) {
                $data['banner'] = $this->utilObjeto->uploadFile($request, $data, $this->path, 'banner', 'image|mimes:jpeg,png,jpg,gif,svg|max:2048');
            }
            if (isset($data['avatar_1_6'])) {
                $data['avatar_1_6'] = $this->utilObjeto->uploadFile($request, $data, $this->path, 'avatar_1_6', 'image|mimes:jpeg,png,jpg,gif,svg|max:2048');
            }
            if (isset($data['avatar_1_1'])) {
                $data['avatar_1_1'] = $this->utilObjeto->uploadFile($request, $data, $this->path, 'avatar_1_1', 'image|mimes:jpeg,png,jpg,gif,svg|max:2048');
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
        $deleted = $this->repository->delete($id);
        return redirect()->back()->with('success', 'Registro removido com sucesso!');
    }

    public function destroyFile($id, $name)
    {
        $dados = $this->repository->find($id);
        if (isset($dados->$name)) {
            $data = $dados->toArray();
            if (isset($dados->$name) && $this->utilObjeto->destroyFile($this->path, $dados->image)) {

                $data[$name] = '';
                $this->repository->update($data, $id);

                return redirect()->back()->with('success', lcfirst($name) . ' removida com sucesso!');
            }

            return redirect()->back()->withErrors('Erro ao excluír ' . lcfirst($name) . '')->withInput();
        }
    }

}
