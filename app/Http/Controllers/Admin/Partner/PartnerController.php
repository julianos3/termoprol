<?php

namespace AgenciaS3\Http\Controllers\Admin\Partner;

use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\AdminRequest;
use AgenciaS3\Repositories\PartnerRepository;
use AgenciaS3\Services\UtilObjeto;
use AgenciaS3\Validators\PartnerValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;


class PartnerController extends Controller
{

    protected $repository;

    protected $validator;

    protected $utilObjeto;

    protected $path;

    public function __construct(PartnerRepository $repository,
                                PartnerValidator $validator,
                                UtilObjeto $utilObjeto)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->path = 'uploads/partner/';
        $this->utilObjeto = $utilObjeto;
    }

    public function index()
    {
        $config = $this->header();
        $dados = $this->repository->orderBy('order', 'asc')->paginate();

        return view('admin.partner.index', compact('dados', 'config'));
    }

    public function header()
    {
        $config['title'] = "Parceiros";
        $config['activeMenu'] = "partner";
        $config['activeMenuN2'] = "partner";

        return $config;
    }

    public function create()
    {
        $config = $this->header();
        $config['action'] = 'Cadastrar';

        return view('admin.partner.create', compact('config', 'users', 'blogs'));
    }

    public function store(AdminRequest $request)
    {
        try {
            $data = $request->all();
            if(isset($data['image'])) {
                $data['image'] = $this->uploadImage($request, $data);
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

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    public function edit($id)
    {
        $config = $this->header();
        $config['action'] = 'Editar';

        $dados = $this->repository->find($id);

        return view('admin.partner.edit', compact('dados', 'config', 'users', 'blogs'));
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

    public function update(AdminRequest $request, $id)
    {
        try {
            $data = $request->all();
            if(isset($data['image'])) {
                $data['image'] = $this->uploadImage($request, $data);
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

            $update = $this->repository->update($data, $id);

            return $update;

        } catch (ValidatorException $e) {
            return false;
        }
    }

    public function destroy($id)
    {
        $this->destroyImage($id);
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

}
