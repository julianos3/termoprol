<?php

namespace AgenciaS3\Http\Controllers\Admin\Configuration\User;

use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\AdminRequest;
use AgenciaS3\Mail\User\UserCreatedMail;
use AgenciaS3\Repositories\UserRepository;
use AgenciaS3\Services\UtilObjeto;
use AgenciaS3\Validators\UserValidator;
use Illuminate\Support\Facades\Mail;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;


class UserController extends Controller
{

    protected $repository;

    protected $validator;

    protected $utilObjeto;

    protected $path;

    public function __construct(UserRepository $repository,
                                UserValidator $validator,
                                UtilObjeto $utilObjeto)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->utilObjeto = $utilObjeto;
        $this->path = 'uploads/users/';
    }

    public function header()
    {
        $config['title'] = "Usuários";
        $config['activeMenu'] = 'configuration';
        $config['activeMenuN2'] = 'user';

        return $config;
    }

    public function index()
    {
        $config = $this->header();
        $dados = $this->repository->orderBy('name', 'asc')->findWhereNotIn('id', [1]);

        return view('admin.configuration.user.index', compact('dados', 'config'));
    }

    public function create()
    {
        $config = $this->header();
        $config['action'] = 'Cadastrar';

        return view('admin.configuration.user.create', compact('config'));
    }

    public function store(AdminRequest $request)
    {
        try {
            $data = $request->all();

            if (isset($data['image'])) {
                $this->validate($request, [
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                $imageName = md5(time()) . '.' . $data['image']->getClientOriginalExtension();
                $request->image->move(public_path($this->path), $imageName);
                $data['image'] = $imageName;
            } else {
                $data['image'] = '';
            }
            $passwordCreated = $data['password'];

            $data['password'] = bcrypt($data['password']);
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
            $user = $this->repository->create($data);

            Mail::to($user->email)->send(new UserCreatedMail($user, $passwordCreated));

            $response = [
                'success' => 'Registro adicionado com sucesso!',
                'data' => $user->toArray(),
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

        return view('admin.configuration.user.edit', compact('dados', 'config'));
    }

    public function update(AdminRequest $request, $id)
    {
        try {
            $data = $request->all();

            //dd(public_path());
            if (isset($data['image'])) {
                $this->validate($request, [
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                $imageName = md5(time()) . '.' . $data['image']->getClientOriginalExtension();
                $request->image->move(public_path($this->path), $imageName);
                $data['image'] = $imageName;
            }

            //$data['password'] = bcrypt($data['password']);
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $User = $this->repository->update($data, $id);

            $response = [
                'success' => 'Registro alterado com sucesso!',
                'data' => $User->toArray(),
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

            $User = $this->repository->update($data, $id);

            return $User;

        } catch (ValidatorException $e) {
            return false;
        }
    }

    public function destroy($id)
    {
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

            return redirect()->back()->withErrors('Erro ao excluír imagem')->withInput();
        }
    }

}
