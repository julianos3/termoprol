<?php

namespace AgenciaS3\Http\Controllers\Admin\Blog;

use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\AdminRequest;
use AgenciaS3\Repositories\PostTagRepository;
use AgenciaS3\Repositories\TagRepository;
use AgenciaS3\Validators\PostTagValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class PostTagController extends Controller
{

    protected $repository;

    protected $validator;

    protected $tagRepository;

    public function __construct(PostTagRepository $repository,
                                PostTagValidator $validator,
                                TagRepository $tagRepository)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->tagRepository = $tagRepository;
    }

    public function index($id)
    {
        $config = $this->header();
        $tags = $this->tagRepository->orderBy('name', 'asc')->findWhere(['active' => 'y']);
        $dados = $this->repository->findWhere(['post_id' => $id]);

        return view('admin.blog.post.tag.index', compact('config', 'tags', 'dados', 'id'));
    }

    public function header()
    {
        $config['title'] = "Post";
        $config['activeMenu'] = 'blog';
        $config['activeMenuN2'] = 'post';
        $config['action'] = 'Tags';

        return $config;
    }

    public function store(AdminRequest $request)
    {
        $data = $request->all();
        $verifica = $this->repository->findWhere([
            'post_id' => $data['post_id'], 'tag_id' => $data['tag_id']
        ]);

        if ($verifica->toArray()) {
            return redirect()->back()->withErrors('Tag já adicionada neste blog.post.')->withInput();
        } else {
            try {

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
    }

    public function destroyAllPost($id)
    {
        return $this->repository->deleteWhere(['post_id' => $id]);
    }

    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);
        return redirect()->back()->with('success', 'Registro removido com sucesso!');
    }

    public function destroyAllTag($id)
    {
        return $this->repository->deleteWhere(['tag_id' => $id]);
    }

}