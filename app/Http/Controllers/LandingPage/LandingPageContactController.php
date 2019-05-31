<?php

namespace AgenciaS3\Http\Controllers\LandingPage;

use AgenciaS3\Entities\Form;
use AgenciaS3\Entities\FormEmail;
use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\SiteRequest;
use AgenciaS3\Mail\LandingPage\LandingPageClientMail;
use AgenciaS3\Mail\LandingPage\LandingPageMail;
use AgenciaS3\Repositories\LandingPageContactRepository;
use AgenciaS3\Repositories\NewsletterRepository;
use AgenciaS3\Services\UtilObjeto;
use AgenciaS3\Validators\LandingPageContactValidator;
use Illuminate\Support\Facades\Mail;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class LandingPageContactController extends Controller
{

    protected $repository;

    protected $validator;

    protected $newsletterRepository;

    public function __construct(LandingPageContactRepository $repository,
                                LandingPageContactValidator $validator,
                                NewsletterRepository $newsletterRepository)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->newsletterRepository = $newsletterRepository;
    }

    public function store(SiteRequest $request)
    {
        try {
            $data = $request->all();
            $data['view'] = 'n';
            $data['ip'] = (new UtilObjeto)->ip();
            $data['session_id'] = session()->getId();

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
            $lead = $this->repository->create($data);

            $dataNews['name'] = $lead->name;
            $dataNews['email'] = $lead->email;
            $check = $this->newsletterRepository->findByField('email', $lead->email)->first();
            if(!$check){
                $this->newsletterRepository->create($data);
            }

            $this->sendMail($lead);

            return response()->json([
                'success' => true,
                'message' => 'Cadastro realizado com sucesso!',
                'data' => $lead->toArray(),
            ]);

        } catch (ValidatorException $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessageBag()
            ]);
        }
    }

    public function sendMail($dados)
    {
        $form = Form::find(1);
        $formEmail = FormEmail::where('form_id', $form->id)->get();

        //email admin
        if ($formEmail->toArray()) {
            $emails = [];
            foreach ($formEmail as $row) {
                $emails[] = $row->email;
            }
            Mail::to($emails)->send(new LandingPageMail($dados));
        }

        //email client
        Mail::to($dados)->send(new LandingPageClientMail($dados, $form));
    }

}
