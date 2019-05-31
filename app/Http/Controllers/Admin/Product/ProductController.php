<?php

namespace AgenciaS3\Http\Controllers\Admin\Product;

use AgenciaS3\Criteria\FindByCategoryCriteria;
use AgenciaS3\Criteria\FindByNameCriteria;
use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\AdminRequest;
use AgenciaS3\Repositories\CategoryRepository;
use AgenciaS3\Repositories\ProductRepository;
use AgenciaS3\Repositories\SubCategoryRepository;
use AgenciaS3\Services\UtilObjeto;
use AgenciaS3\Validators\ProductValidator;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;


class ProductController extends Controller
{

    protected $repository;

    protected $validator;

    protected $categoryRepository;

    protected $subCategoryRepository;

    protected $utilObjeto;

    protected $path;

    public function __construct(ProductRepository $repository,
                                ProductValidator $validator,
                                CategoryRepository $categoryRepository,
                                SubCategoryRepository $subCategoryRepository,
                                UtilObjeto $utilObjeto)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->categoryRepository = $categoryRepository;
        $this->subCategoryRepository = $subCategoryRepository;
        $this->utilObjeto = $utilObjeto;
        $this->path = 'uploads/product/';
    }

    public function index(Request $request)
    {
        $name = $request->get('name');
        $category_id = $request->get('category_id');
        if (isset($name) || isset($category_id)) {
            $this->repository->pushCriteria(new FindByNameCriteria($request->get('name')))
                ->pushCriteria(new FindByCategoryCriteria($request->get('category_id')));
        } else {
            $this->repository->skipCriteria();
        }

        $config = $this->header();
        $dados = $this->repository->orderBy('order', 'asc')->paginate();
        $categories = $this->categoryRepository->orderBy('name', 'asc')->pluck('name', 'id')->prepend('Categoria', '');

        return view('admin.product.index', compact('dados', 'config', 'categories'));
    }

    public function header()
    {
        $config['title'] = "Produtos";
        $config['activeMenu'] = "product";
        $config['activeMenuN2'] = "product";

        return $config;
    }

    public function create()
    {
        $config = $this->header();
        $config['action'] = 'Cadastrar';

        $categories = $this->categoryRepository->orderBy('name', 'asc')->pluck('name', 'id')->prepend('Selecione', '');

        return view('admin.product.create', compact('config', 'categories'));
    }

    public function store(AdminRequest $request)
    {
        try {
            $data = $request->all();
            $data['price'] = trataCampoValor($data['price']);
            $data['seo_link'] = $this->utilObjeto->nameUrl($data['name']);

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
        $dados['price'] = formata_valor($dados->price);

        $categories = $this->categoryRepository->orderBy('name', 'asc')->pluck('name', 'id')->prepend('Selecione', '');

        if($dados->category_id) {
            $subcategories = $this->subCategoryRepository
                ->orderBy('name', 'asc')
                ->findByField('category_id', $dados->category_id)
                ->pluck('name', 'id')
                ->prepend('Selecione', '');
        }
        return view('admin.product.edit', compact('dados', 'config', 'categories', 'subcategories'));
    }

    public function update(AdminRequest $request, $id)
    {
        try {
            $data = $request->all();
            $data['price'] = trataCampoValor($data['price']);
            $data['seo_link'] = $this->utilObjeto->nameUrl($data['name']);

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
