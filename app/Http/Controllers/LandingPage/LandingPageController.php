<?php

namespace AgenciaS3\Http\Controllers\LandingPage;

use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\SiteRequest;
use AgenciaS3\Repositories\LandingPageProductRepository;
use AgenciaS3\Repositories\LandingPageRepository;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Facades\Route;

class LandingPageController extends Controller
{

    protected $repository;

    protected $landingPageProductRepository;

    public function __construct(LandingPageRepository $repository,
                                LandingPageProductRepository $landingPageProductRepository)
    {
        $this->repository = $repository;
        $this->landingPageProductRepository = $landingPageProductRepository;
    }

    public function index()
    {
        $dados = $this->repository->orderBy('name', 'asc')->all()->first();

        return redirect()->route('landing-page.show', $dados->seo_link);
    }

    public function show(SiteRequest $request, $seo_link)
    {
        $landingPage = $this->repository->findWhere(['seo_link' => $seo_link, 'active' => 'y'])->first();
        if ($landingPage) {

            $cover = asset('assets/store/images/logo_facebook.jpg');
            $cover2 = asset('assets/store/images/logo_facebook_2.jpg');

            if (isPost($landingPage->avatar_1_6)) {
                $cover2 = asset('uploads/landing-page/' . $landingPage->avatar_1_6);
            }
            if (isPost($landingPage->avatar_1_1)) {
                $cover2 = asset('uploads/landing-page/' . $landingPage->avatar_1_1);
            }
            SEOMeta::setTitle($landingPage->name);
            SEOMeta::setDescription($landingPage->seo_description);
            SEOMeta::setCanonical(Route::getCurrentRequest()->getUri());
            SEOMeta::addKeyword([$landingPage->seo_keywords]);
            TwitterCard::setTitle($landingPage->name);
            TwitterCard::setDescription($landingPage->seo_description);
            TwitterCard::addImage($cover);

            OpenGraph::setDescription($landingPage->seo_description);
            OpenGraph::setTitle($landingPage->name);
            OpenGraph::setUrl(Route::getCurrentRequest()->getUri());
            OpenGraph::addProperty('type', 'article');
            OpenGraph::addProperty('locale', 'pt-br');
            OpenGraph::addImage($cover, ['height' => 630, 'width' => 1200]);
            OpenGraph::addImage($cover);
            OpenGraph::addImage(['url' => $cover2, 'size' => 300]);
            OpenGraph::addImage($cover2, ['height' => 300, 'width' => 300]);

            $products = $this->landingPageProductRepository
                ->orderBy('order', 'asc')
                ->findWhere(['landing_page_id' => $landingPage->id, 'active' => 'y']);

            return view('landing-page.home.index', compact('landingPage', 'products'));
        }

        return redirect()->route('home');

    }

}
