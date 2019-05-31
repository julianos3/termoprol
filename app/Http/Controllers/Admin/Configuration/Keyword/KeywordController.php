<?php

namespace AgenciaS3\Http\Controllers\Admin\Configuration\Keyword;

use AgenciaS3\Criteria\FindByNameCriteria;
use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\AdminRequest;
use AgenciaS3\Repositories\KeywordRepository;
use AgenciaS3\Validators\KeywordValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class KeywordController extends Controller
{

    protected $repository;

    protected $validator;

    public function __construct(KeywordRepository $repository,
                                KeywordValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function index(AdminRequest $request)
    {
        $name = $request->get('name');
        if (isset($name)) {
            $this->repository->pushCriteria(new FindByNameCriteria($request->get('name')));
        } else {
            $this->repository->skipCriteria();
        }

        $config = $this->header();
        $dados = $this->repository->orderBy('name', 'asc')->paginate();

        return view('admin.configuration.keyword.index', compact('dados', 'config'));
    }

    public function header()
    {
        $config['title'] = "Keywords";
        $config['activeMenu'] = "configuration";
        $config['activeMenuN2'] = "keyword";

        return $config;
    }

    public function create()
    {
        $config = $this->header();
        $config['action'] = 'Cadastrar';

        return view('admin.configuration.keyword.create', compact('config'));
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
        return view('admin.configuration.keyword.edit', compact('dados', 'config'));
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
            if ($dados->toArray()) {

                $data = $dados->toArray();
                if ($dados->active == 'y') {
                    $data['active'] = 'n';
                } else {
                    $data['active'] = 'y';
                }

                $dados = $this->repository->update($data, $id);

                return $dados;
            }

            return false;

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
