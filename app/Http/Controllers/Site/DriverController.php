<?php

namespace AgenciaS3\Http\Controllers\Site;

use AgenciaS3\Entities\Form;
use AgenciaS3\Entities\FormEmail;
use AgenciaS3\Entities\SeoPage;
use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\SiteRequest;
use AgenciaS3\Mail\Driver\DriverClientMail;
use AgenciaS3\Mail\Driver\DriverMail;
use AgenciaS3\Repositories\DriverAdvantageRepository;
use AgenciaS3\Repositories\DriverContactRepository;
use AgenciaS3\Repositories\DriverTestimonyRepository;
use AgenciaS3\Repositories\PartnerRepository;
use AgenciaS3\Repositories\RequirementDriverRepository;
use AgenciaS3\Services\UtilObjeto;
use AgenciaS3\Validators\DriverContactValidator;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class DriverController extends Controller
{

    protected $driverAdvantageRepository;

    protected $driverTestimonyRepository;

    protected $driverContactRepository;

    protected $driverContactValidator;

    protected $requirementDriverRepository;

    public function __construct(DriverAdvantageRepository $driverAdvantageRepository,
                                DriverTestimonyRepository $driverTestimonyRepository,
                                DriverContactRepository $driverContactRepository,
                                DriverContactValidator $driverContactValidator,
                                RequirementDriverRepository $requirementDriverRepository)
    {
        $this->driverAdvantageRepository = $driverAdvantageRepository;
        $this->driverTestimonyRepository = $driverTestimonyRepository;
        $this->driverContactRepository = $driverContactRepository;
        $this->driverContactValidator = $driverContactValidator;
        $this->requirementDriverRepository = $requirementDriverRepository;
    }

    public function index(SiteRequest $request)
    {
        $configSEO = SeoPage::find(4);

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

        $advantages = $this->driverAdvantageRepository->orderBy('order', 'asc')->findByField('active', 'y');
        $testimonies = $this->driverTestimonyRepository->orderBy('order', 'asc')->findByField('active', 'y');
        $requirementDrivers = $this->requirementDriverRepository->orderBy('order', 'asc')->findByField('active', 'y');

        return view('site.driver.index', compact('advantages', 'testimonies', 'requirementDrivers'));
    }

    public function store(SiteRequest $request)
    {
        try {
            $data = $request->all();
            $data['view'] = 'n';

            $data['ip'] = (new UtilObjeto)->ip();
            $data['session_id'] = $request->session()->getId();

            $this->driverContactValidator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
            $contact = $this->driverContactRepository->create($data);

            $this->sendMail($contact);

            return response()->json([
                'success' => true,
                'message' => 'Cadastro enviado com sucesso!'
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
        $form = Form::find(4);
        $formEmail = FormEmail::where('form_id', $form->id)->get();

        //email admin
        if ($formEmail->toArray()) {
            $emails = [];
            foreach ($formEmail as $row) {
                $emails[] = $row->email;
            }
            Mail::to($emails)->send(new DriverMail($dados));
        }

        //email client
        Mail::to($dados)->send(new DriverClientMail($dados, $form));
    }



}
