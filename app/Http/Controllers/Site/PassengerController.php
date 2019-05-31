<?php

namespace AgenciaS3\Http\Controllers\Site;

use AgenciaS3\Entities\Form;
use AgenciaS3\Entities\FormEmail;
use AgenciaS3\Entities\PassengerContact;
use AgenciaS3\Entities\SeoPage;
use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\SiteRequest;
use AgenciaS3\Mail\Passenger\PassengerClientMail;
use AgenciaS3\Mail\Passenger\PassengerMail;
use AgenciaS3\Repositories\ModalityRepository;
use AgenciaS3\Repositories\PassengerContactRepository;
use AgenciaS3\Services\UtilObjeto;
use AgenciaS3\Validators\PassengerContactValidator;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class PassengerController extends Controller
{

    protected $modalityRepository;

    protected $passengerContactRepository;

    protected $passengerContactValidator;

    public function __construct(ModalityRepository $modalityRepository,
                                PassengerContactRepository $passengerContactRepository,
                                PassengerContactValidator $passengerContactValidator)
    {
        $this->modalityRepository = $modalityRepository;
        $this->passengerContactRepository = $passengerContactRepository;
        $this->passengerContactValidator = $passengerContactValidator;
    }

    public function index(SiteRequest $request)
    {
        $configSEO = SeoPage::find(5);

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

        return view('site.passenger.index', compact('banners', 'bannerMobile', 'posts', 'modalities'));
    }

    public function store(SiteRequest $request)
    {
        try {
            $data = $request->all();
            $data['view'] = 'n';

            $data['ip'] = (new UtilObjeto)->ip();
            $data['session_id'] = $request->session()->getId();

            $this->passengerContactValidator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
            $contact = $this->passengerContactRepository->create($data);

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
        $form = Form::find(6);
        $formEmail = FormEmail::where('form_id', $form->id)->get();

        //email admin
        if ($formEmail->toArray()) {
            $emails = [];
            foreach ($formEmail as $row) {
                $emails[] = $row->email;
            }

            Mail::to($emails)->send(new PassengerMail($dados));

        }

        //email client
        //Mail::to($dados)->send(new PassengerClientMail($dados, $form));
    }

}
