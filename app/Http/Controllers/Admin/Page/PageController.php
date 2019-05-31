<?php

namespace AgenciaS3\Http\Controllers\Admin\Page;

use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\AdminRequest;
use AgenciaS3\Repositories\BlogRepository;
use AgenciaS3\Repositories\PageRepository;
use AgenciaS3\Services\UtilObjeto;
use AgenciaS3\Validators\PageValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class PageController extends Controller
{

    protected $repository;

    protected $validator;

    protected $utilObjeto;

    protected $path;

    public function __construct(PageRepository $repository,
                                PageValidator $validator,
                                UtilObjeto $utilObjeto)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->utilObjeto = $utilObjeto;
        $this->path = 'uploads/page/';
    }

    public function index()
    {
        $config = $this->header();
        $dados = $this->repository->paginate();

        return view('admin.page.index', compact('dados', 'config'));
    }

    public function header()
    {
        $config['title'] = "Páginas e Textos";
        $config['activeMenu'] = "page";
        $config['activeMenuN2'] = "page";

        return $config;
    }

    public function create()
    {
        $config = $this->header();
        $config['action'] = 'Cadastrar';

        return view('admin.page.create', compact('config'));
    }

    public function store(AdminRequest $request)
    {
        try {
            $data = $request->all();

            if (isset($data['image'])) {
                $this->validate($request, [
                    'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                $imageName = md5(time() . rand(1, 10)) . '.' . $data['image']->getClientOriginalExtension();
                $request->image->move(public_path($this->path), $imageName);
                $data['image'] = $imageName;
            }
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
            $dados = $this->repository->create($data);

            $response = [
                'success' => 'Registro adicionado com sucesso!',
                'data' => $dados->toArray(),
            ];

            return redirect()->route('admin.page.edit', ['id' => $dados->id])->with('success', $response['success']);
            //return redirect()->back()->with('success', $response['success']);

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

        if($id == 1) {
            $imageSize = '900px X 615px';
        }
        if($id == 2) {
            $imageSize = '360px X 615px';
        }
        if($id == 3) {
            $imageSize = '500px X 500px';
        }
        if($id == 7) {
            $imageSize = '1920px X Ajustável';
        }
        if($id == 10) {
            $imageSize = '286px X 575px';
        }
        if($id == 19) {
            $imageSize = '770px X 770px';
        }
        if($id == 15) {
            $imageSize = '975px X 460px';
        }

        if($id == 1 || $id == 2 || $id == 3 || $id == 4 || $id == 5 || $id == 6 || $id == 18){
            $config['activeMenu'] = "garupa";
        }

        if($id == 7 || $id == 8 || $id == 9){
            $config['activeMenu'] = "driver";
        }

        if($id == 10 || $id == 11 || $id == 25 || $id == 26 || $id == 27 || $id == 28){
            $config['activeMenu'] = 'passenger';
        }

        if($id == 19 || $id == 20 || $id == 21 || $id == 13 || $id == 14 || $id == 15 || $id == 22 || $id == 16 || $id == 17){
            $config['activeMenu'] = 'trading-partner';
        }

        $config['activeMenuN2'] = "page-".$id;
        $dados = $this->repository->find($id);

        return view('admin.page.edit', compact('dados', 'config', 'imageSize'));
    }

    public function update(AdminRequest $request, $id)
    {
        try {
            $data = $request->all();
            $data['seo_link'] = $this->utilObjeto->nameUrl($data['name']);

            if (isset($data['image'])) {
                $this->validate($request, [
                    'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                $imageName = md5(time() . rand(1, 10)) . '.' . $data['image']->getClientOriginalExtension();
                $request->image->move(public_path($this->path), $imageName);
                $data['image'] = $imageName;
                //remove imagem atual
                $this->destroyImage($id);
            }

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

            return redirect()->back()->withErrors('Erro ao excluír imagem')->withInput();
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
            return redirect()->back()->withErrors("Erro ao ativar/desativar!")->withInput();
        }
    }

    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);
        return redirect()->back()->with('success', 'Registro removido com sucesso!');
    }

}
