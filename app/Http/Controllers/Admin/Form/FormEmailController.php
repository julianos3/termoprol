<?php

namespace AgenciaS3\Http\Controllers\Admin\Form;

use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\AdminRequest;
use AgenciaS3\Repositories\FormEmailRepository;
use AgenciaS3\Validators\FormEmailValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class FormEmailController extends Controller
{

    protected $repository;

    protected $validator;

    public function __construct(FormEmailRepository $repository,
                                FormEmailValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function index($id)
    {
        $config = $this->header();
        $dados = $this->repository->findWhere(['form_id' => $id]);

        return view('admin.form.email.index', compact('config', 'dados', 'id'));
    }

    public function header()
    {
        $config['title'] = "Formulários";
        $config['activeMenu'] = "form";
        $config['activeMenuN2'] = "form";
        $config['action'] = 'E-mails';

        return $config;
    }

    public function store(AdminRequest $request)
    {
        $data = $request->all();
        $verifica = $this->repository->findWhere([
            'email' => $data['email'],
            'form_id' => $data['form_id']
        ]);

        if ($verifica->toArray()) {
            return redirect()->back()->withErrors('E-mail já cadastrado neste formulário.')->withInput();
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

    public function destroyAllForm($idNews)
    {
        $dados = $this->repository->findWhere(['form_id' => $idNews]);
        if ($dados->toArray()) {
            foreach ($dados as $row) {
                $this->destroy($row->id);
            }
        }
        return true;
    }

    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);
        return redirect()->back()->with('success', 'Registro removido com sucesso!');
    }

    public function destroyAllEmail($idTag)
    {
        $dados = $this->repository->findWhere(['form_id' => $idTag]);
        if ($dados->toArray()) {
            foreach ($dados as $row) {
                $this->destroy($row->id);
            }
        }
        return true;
    }

}