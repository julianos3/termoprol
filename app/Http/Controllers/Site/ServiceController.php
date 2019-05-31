<?php

namespace AgenciaS3\Http\Controllers\Site;

use AgenciaS3\Entities\BannerPage;
use AgenciaS3\Entities\SeoPage;
use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\SiteRequest;
use AgenciaS3\Repositories\ModalityRepository;
use AgenciaS3\Repositories\PostRepository;
use AgenciaS3\Repositories\ServiceRepository;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Facades\Route;

class ServiceController extends Controller
{

    protected $repository;

    protected $postRepository;

    protected $modalityRepository;

    public function __construct(ServiceRepository $repository,
                                PostRepository $postRepository,
                                ModalityRepository $modalityRepository)
    {
        $this->repository = $repository;
        $this->postRepository = $postRepository;
        $this->modalityRepository = $modalityRepository;
    }

    public function index(SiteRequest $request)
    {
        $configSEO = SeoPage::find(3);

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

        $services = $this->repository->orderBy('order', 'asc')->findByField('active', 'y');
        $modalities = $this->modalityRepository->orderBy('order', 'asc')->findByField('active', 'y');

        $banner = BannerPage::where('id', 1)->where('active', 'y')->get()->first();

        return view('site.service.index', compact('services', 'modalities', 'banner'));
    }

    public function show($seo_link)
    {
        $service = $this->repository->findWhere(['active' => 'y', 'seo_link' => $seo_link])->first();
        if ($service) {

            $cover = asset('assets/store/images/logo_facebook.jpg');
            $cover2 = asset('assets/store/images/logo_facebook_2.jpg');
            SEOMeta::setTitle($service->name);
            SEOMeta::setDescription($service->seo_description);
            SEOMeta::setCanonical(Route::getCurrentRequest()->getUri());
            TwitterCard::setTitle($service->name);
            TwitterCard::setDescription($service->seo_description);
            TwitterCard::addImage($cover);

            OpenGraph::setDescription($service->seo_description);
            OpenGraph::setTitle($service->name);
            OpenGraph::setUrl(Route::getCurrentRequest()->getUri());
            OpenGraph::addProperty('type', 'article');
            OpenGraph::addProperty('locale', 'pt-br');
            OpenGraph::addImage($cover, ['height' => 630, 'width' => 1200]);
            OpenGraph::addImage($cover);
            OpenGraph::addImage(['url' => $cover2, 'size' => 300]);
            OpenGraph::addImage($cover2, ['height' => 300, 'width' => 300]);

            $posts = $this->postRepository->getPostsActive(3);
            $serviceNext = $this->repository->scopeQuery(function ($query) use ($service) {
                $query = $query->where('active', 'y')
                    ->where('id', '!=', $service->id)
                    ->where('order', '>=', $service->order);

                return $query;
            })->first();

            if (!$serviceNext) {
                $serviceNext = $this->repository->scopeQuery(function ($query) use ($service) {
                    $query = $query->where('active', 'y')
                        ->where('id', '!=', $service->id)
                        ->orderBy('order', 'asc');

                    return $query;
                })->first();
            }

            return view('site.service.show', compact('service', 'posts', 'serviceNext'));
        }

        return redirect()->route('service');
    }

    public function getMenuServices()
    {
        return $this->repository->orderBy('order', 'asc')->findByField('active', 'y');
    }

}
