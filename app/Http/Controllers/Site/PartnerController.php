<?php

namespace AgenciaS3\Http\Controllers\Site;

use AgenciaS3\Entities\SeoPage;
use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\SiteRequest;
use AgenciaS3\Repositories\PartnerRepository;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Facades\Route;

class PartnerController extends Controller
{

    protected $repository;

    public function __construct(PartnerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(SiteRequest $request)
    {
        $configSEO = SeoPage::find(7);

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

        $partners = $this->repository->orderBy('order', 'asc')->findByField('active', 'y');

        return view('site.partner.index', compact('banners', 'bannerMobile', 'posts', 'partners'));
    }

}
