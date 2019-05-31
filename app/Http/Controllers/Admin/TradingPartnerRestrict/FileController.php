<?php

namespace AgenciaS3\Http\Controllers\Admin\TradingPartnerRestrict;

use AgenciaS3\Criteria\FindByNameCriteria;
use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\AdminRequest;
use AgenciaS3\Repositories\CategoryRepository;
use AgenciaS3\Repositories\FileRepository;
use AgenciaS3\Services\UtilObjeto;
use AgenciaS3\Validators\FileValidator;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;


class FileController extends Controller
{

    protected $repository;

    protected $validator;

    protected $categoryRepository;

    protected $utilObjeto;

    protected $path;

    public function __construct(FileRepository $repository,
                                FileValidator $validator,
                                CategoryRepository $categoryRepository,
                                UtilObjeto $utilObjeto)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->categoryRepository = $categoryRepository;
        $this->utilObjeto = $utilObjeto;
        $this->path = 'uploads/file/';
    }

    public function index(Request $request)
    {
        $search = $request->get('name');
        if (isset($search)) {
            $this->repository->pushCriteria(new FindByNameCriteria($search));
        } else {
            $this->repository->skipCriteria();
        }


        $config = $this->header();
        $dados = $this->repository->with('category')->orderBy('created_at', 'desc')->paginate();

        return view('admin.trading-partner-restrict.file.index', compact('dados', 'config'));
    }

    public function header()
    {
        $config['title'] = "Arquivos";
        $config['activeMenu'] = "trading-partner-restrict";
        $config['activeMenuN2'] = "file";

        return $config;
    }

    public function create()
    {
        $config = $this->header();
        $config['action'] = 'Cadastrar';

        $categories = $this->categoryRepository->orderBy('name', 'asc')->pluck('name', 'id')->prepend('Selecione', '');

        return view('admin.trading-partner-restrict.file.create', compact('config', 'categories'));
    }

    public function store(AdminRequest $request)
    {
        try {
            $data = $request->all();
            if (isset($data['file'])) {
                $data['file'] = $this->upload($request, $data);
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

    public function upload($request, $data)
    {
        if (isset($data['file'])) {
            $this->validate($request, [
                'file' => 'required',
            ]);

            $imageName = md5(time()) . '.' . $data['file']->getClientOriginalExtension();
            $request->file->move(public_path($this->path), $imageName);
            $data['file'] = $imageName;

            return $data['file'];
        }

        return null;
    }

    public function edit($id)
    {
        $config = $this->header();
        $config['action'] = 'Editar';
        $dados = $this->repository->find($id);
        $categories = $this->categoryRepository->orderBy('name', 'asc')->pluck('name', 'id')->prepend('Selecione', '');

        return view('admin.trading-partner-restrict.file.edit', compact('dados', 'config', 'categories'));
    }

    public function update(AdminRequest $request, $id)
    {
        try {
            $data = $request->all();
            if (isset($data['file'])) {
                $data['file'] = $this->upload($request, $data);
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


    public function destroyFile($id)
    {
        $dados = $this->repository->find($id);
        if (isset($dados->file)) {
            $data = $dados->toArray();
            if (isset($dados->file) && $this->utilObjeto->destroyFile($this->path, $dados->file)) {

                $data['file'] = '';
                $this->repository->update($data, $id);

                return redirect()->back()->with('success', 'Arquivo removido com sucesso!');
            }

            return redirect()->back()->withErrors('Erro ao excluír Arquivo')->withInput();
        }
    }

}
