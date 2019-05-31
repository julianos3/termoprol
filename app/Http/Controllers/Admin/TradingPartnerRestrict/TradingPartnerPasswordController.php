<?php

namespace AgenciaS3\Http\Controllers\Admin\TradingPartnerRestrict;

use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\AdminRequest;
use AgenciaS3\Mail\TradingPartnerRestrict\TradingPartner\TradingPartnerNewPasswordMail;
use AgenciaS3\Repositories\TradingPartnerRepository;
use AgenciaS3\Services\UtilObjeto;
use AgenciaS3\Validators\TradingPartnerPasswordValidator;
use Illuminate\Support\Facades\Mail;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;


class TradingPartnerPasswordController extends Controller
{

    protected $repository;

    protected $validator;

    public function __construct(TradingPartnerRepository $repository,
                                TradingPartnerPasswordValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function edit($id)
    {
        $config['title'] = "Sócio Operador";
        $config['activeMenu'] = 'trading-partner-restrict';
        $config['activeMenuN2'] = 'trading-partner';
        $config['action'] = 'Alterar Senha';
        $dados = $this->repository->find($id);

        return view('admin.trading-partner-restrict.trading-partner.password.edit', compact('dados', 'config'));
    }

    public function update(AdminRequest $request, $id)
    {
        try {
            $dataPassword = $request->all();
            $passwordCreated = $dataPassword['password'];
            $data = $this->repository->find($id)->toArray();

            $data['password'] = $dataPassword['password'];
            $data['password_confirmation'] = $dataPassword['password_confirmation'];

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $data['password'] = bcrypt($passwordCreated);
            $dados = $this->repository->update($data, $id);

            Mail::to($dados->email)->send(new TradingPartnerNewPasswordMail($dados, $passwordCreated));

            $response = [
                'success' => 'Senha atualizada e enviada por e-mail com sucesso!',
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
        Mail::to($user->email)->send(new TradingPartnerNewPasswordMail($user, $passwordCreated));

        $data = $user->toArray();
        $data['password'] = bcrypt($passwordCreated);
        $dados = $this->repository->update($data, $id);

        $response = [
            'success' => 'Senha atualizada e enviada por e-mail com sucesso!',
            'data' => $user->toArray(),
        ];

        return redirect()->back()->with('success', $response['success']);
    }

}
