<?php

namespace AgenciaS3\Http\Controllers\Site;

use AgenciaS3\Entities\Form;
use AgenciaS3\Entities\FormEmail;
use AgenciaS3\Entities\SeoPage;
use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\SiteRequest;
use AgenciaS3\Mail\TradingPartner\TradingPartnerClientMail;
use AgenciaS3\Mail\TradingPartner\TradingPartnerMail;
use AgenciaS3\Mail\TradingPartner\TradingPartnerRegisterMail;
use AgenciaS3\Repositories\ModalityRepository;
use AgenciaS3\Repositories\TradingParnerTestimonyRepository;
use AgenciaS3\Repositories\TradingPartnerContactRepository;
use AgenciaS3\Services\UtilObjeto;
use AgenciaS3\Validators\TradingPartnerContactValidator;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class TradingPartnerController extends Controller
{

    protected $modalityRepository;

    protected $tradingParnerTestimonyRepository;

    protected $repository;

    protected $validator;

    public function __construct(ModalityRepository $modalityRepository,
                                TradingParnerTestimonyRepository $tradingParnerTestimonyRepository,
                                TradingPartnerContactRepository $repository,
                                TradingPartnerContactValidator $validator)
    {
        $this->modalityRepository = $modalityRepository;
        $this->tradingParnerTestimonyRepository = $tradingParnerTestimonyRepository;
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function index(SiteRequest $request)
    {
        $configSEO = SeoPage::find(6);

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

        $modalities = $this->modalityRepository->orderBy('order', 'asc')->findByField('active', 'y');
        $testimonies = $this->tradingParnerTestimonyRepository->orderBy('order', 'asc')->findByField('active', 'y');

        return view('site.trading-partner.index', compact('testimonies', 'modalities'));
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
                'message' => 'Cadastro realizado com sucesso!'
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
        $form = Form::find(3);
        $formEmail = FormEmail::where('form_id', $form->id)->get();

        //email admin
        if ($formEmail->toArray()) {
            $emails = [];
            foreach ($formEmail as $row) {
                $emails[] = $row->email;
            }
            Mail::to($emails)->send(new TradingPartnerMail($dados));
        }

        //email client
        //Mail::to($dados)->send(new TradingPartnerClientMail($dados, $form));
    }

    public function register(SiteRequest $request)
    {
        $configSEO = SeoPage::find(11);

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

        return view('site.trading-partner.register', compact('testimonies', 'modalities'));
    }

    public function RegisterStore(SiteRequest $request)
    {
        try {
            $data = $request->all();
            $data['view'] = 'n';
            $data['ip'] = (new UtilObjeto)->ip();
            $data['session_id'] = $request->session()->getId();

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
            $contact = $this->repository->create($data);

            $this->sendMailRegister($contact);

            return response()->json([
                'success' => true,
                'message' => 'Cadastro realizado com sucesso!'
            ]);

        } catch (ValidatorException $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessageBag()
            ]);
        }
    }

    public function sendMailRegister($dados)
    {
        $form = Form::find(3);
        $formEmail = FormEmail::where('form_id', $form->id)->get();

        //email admin
        if ($formEmail->toArray()) {
            $emails = [];
            foreach ($formEmail as $row) {
                $emails[] = $row->email;
            }
            Mail::to($emails)->send(new TradingPartnerRegisterMail($dados));
        }

        //email client
        Mail::to($dados)->send(new TradingPartnerClientMail($dados, $form));
    }

}
