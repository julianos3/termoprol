<?php

namespace AgenciaS3\Http\Controllers\Admin\Configuration\User;

use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\AdminRequest;
use AgenciaS3\Mail\User\UserNewPasswordMail;
use AgenciaS3\Repositories\UserRepository;
use AgenciaS3\Services\UtilObjeto;
use AgenciaS3\Validators\UserValidator;
use Illuminate\Support\Facades\Mail;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;


class UserPasswordController extends Controller
{

    protected $repository;

    protected $validator;

    public function __construct(UserRepository $repository,
                                UserValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function edit($id)
    {
        $config['title'] = "Usuários";
        $config['activeMenu'] = 'configuration';
        $config['activeMenuN2'] = 'user';
        $config['action'] = 'Alterar Senha';
        $dados = $this->repository->find($id);

        return view('admin.configuration.user.password.edit', compact('dados', 'config'));
    }

    public function update(AdminRequest $request, $id)
    {
        try {
            $dataPassword = $request->all();
            $passwordCreated = $dataPassword['password'];
            $data = $this->repository->find($id)->toArray();
            $data['password'] = bcrypt($dataPassword['password']);

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $dados = $this->repository->update($data, $id);

            Mail::to($dados->email)->send(new UserNewPasswordMail($dados, $passwordCreated));

            $response = [
                'success' => 'Senha atualizada com sucesso!',
                'data' => $dados->toArray(),
            ];

            return redirect()->back()->with('success', $response['success']);

        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    public function generatePassword($id)
    {
        $user = $this->repository->find($id);
        $utilObjeto = new UtilObjeto();
        $passwordCreated = $utilObjeto->geraSenha();
        Mail::to($user->email)->send(new UserNewPasswordMail($user, $passwordCreated));
        $response = [
            'success' => 'Senha atualizada e enviada com sucesso!',
            'data' => $user->toArray(),
        ];

        return redirect()->back()->with('success', $response['success']);
    }

}
