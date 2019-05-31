<?php

namespace AgenciaS3\Http\Controllers\Site;

use AgenciaS3\Entities\Form;
use AgenciaS3\Entities\FormEmail;
use AgenciaS3\Entities\SeoPage;
use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\SiteRequest;
use AgenciaS3\Mail\LandingPage\ContactClientMail;
use AgenciaS3\Mail\LandingPage\ContactMail;
use AgenciaS3\Repositories\ContactProfileRepository;
use AgenciaS3\Repositories\ContactRepository;
use AgenciaS3\Services\UtilObjeto;
use AgenciaS3\Validators\ContactValidator;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class ContactController extends Controller
{

    protected $repository;

    protected $validator;

    protected $contactProfileRepository;

    public function __construct(ContactRepository $repository,
                                ContactValidator $validator,
                                ContactProfileRepository $contactProfileRepository)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->contactProfileRepository = $contactProfileRepository;
    }

    public function index(SiteRequest $request)
    {
        $configSEO = SeoPage::find(8);

        $cover = asset('assets/store/images/logo_facebook.jpg');
        $cover2 = asset('assets/store/images/logo_facebook_2.jpg');
        SEOMeta::setTitle($configSEO->name);
        SEOMeta::setDescription($configSEO->seo_description);
        SEOMeta::setCanonical(Route::getCurrentRequest()->getUri());
        SEOMeta::addKeyword([$configSEO->seo_keywords]);
        TwitterCard::setTitle($configSEO->name);
        TwitterCard::setDescription($configSEO->seo_description);
        TwitterCard::addImage($cover);

        OpenGraph::setDescription($configSEO->seo_description);
        OpenGraph::setTitle($configSEO->name);
        OpenGraph::setUrl(Route::getCurrentRequest()->getUri());
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'pt-br');
        OpenGraph::addImage($cover, ['height' => 630, 'width' => 1200]);
        OpenGraph::addImage($cover);
        OpenGraph::addImage(['url' => $cover2, 'size' => 300]);
        OpenGraph::addImage($cover2, ['height' => 300, 'width' => 300]);

        return view('site.contact.index');
    }

    public function getProfiles()
    {
        return $this->contactProfileRepository->orderBy('order', 'asc')->findByField('active', 'y');
    }

    public function store(SiteRequest $request)
    {
        try {
            $data = $request->all();
            $data['view'] = 'n';

            $data['ip'] = (new UtilObjeto)->ip();
            $data['session_id'] = $request->session()->getId();

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
            $contact = $this->repository->create($data);

            $this->sendMail($contact);

            return response()->json([
                'success' => true,
                'message' => 'Contato enviado com sucesso!',
                'data' => $contact->toArray(),
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
        $form = Form::find(2);
        $formEmail = FormEmail::where('form_id', $form->id)->get();

        //email admin
        if ($formEmail->toArray()) {
            $emails = [];
            foreach ($formEmail as $row) {
                $emails[] = $row->email;
            }

            if(isPost($dados->profile->email)) {
                Mail::to($dados->profile->email)->send(new ContactMail($dados));
            }else {
                Mail::to($emails)->send(new ContactMail($dados));
            }
        }

        //email client
        Mail::to($dados)->send(new ContactClientMail($dados, $form));
    }

}
