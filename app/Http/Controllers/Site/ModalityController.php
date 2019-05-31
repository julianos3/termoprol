<?php

namespace AgenciaS3\Http\Controllers\Site;

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

class ModalityController extends Controller
{

    protected $repository;

    protected $postRepository;

    protected $serviceRepository;

    public function __construct(ModalityRepository $repository,
                                PostRepository $postRepository,
                                ServiceRepository $serviceRepository)
    {
        $this->repository = $repository;
        $this->postRepository = $postRepository;
        $this->serviceRepository = $serviceRepository;
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

        $modalities = $this->repository->orderBy('order', 'asc')->findByField('active', 'y');
        $services = $this->serviceRepository->orderBy('order', 'asc')->findByField('active', 'y');

        return view('site.modality.index', compact('services', 'modalities'));
    }

    public function show($seo_link)
    {
        $modality = $this->repository->findWhere(['active' => 'y', 'seo_link' => $seo_link])->first();
        if ($modality) {

            $cover = asset('assets/store/images/logo_facebook.jpg');
            $cover2 = asset('assets/store/images/logo_facebook_2.jpg');
            SEOMeta::setTitle($modality->name);
            SEOMeta::setDescription($modality->seo_description);
            SEOMeta::setCanonical(Route::getCurrentRequest()->getUri());
            TwitterCard::setTitle($modality->name);
            TwitterCard::setDescription($modality->seo_description);
            TwitterCard::addImage($cover);

            OpenGraph::setDescription($modality->seo_description);
            OpenGraph::setTitle($modality->name);
            OpenGraph::setUrl(Route::getCurrentRequest()->getUri());
            OpenGraph::addProperty('type', 'article');
            OpenGraph::addProperty('locale', 'pt-br');
            OpenGraph::addImage($cover, ['height' => 630, 'width' => 1200]);
            OpenGraph::addImage($cover);
            OpenGraph::addImage(['url' => $cover2, 'size' => 300]);
            OpenGraph::addImage($cover2, ['height' => 300, 'width' => 300]);

            $posts = $this->postRepository->getPostsActive(3);
            $modalityNext = $this->repository->scopeQuery(function ($query) use ($modality) {
                $query = $query->where('active', 'y')
                    ->where('id', '!=', $modality->id)
                    ->where('order', '>=', $modality->order);

                return $query;
            })->first();

            if (!$modalityNext) {
                $modalityNext = $this->repository->scopeQuery(function ($query) use ($modality) {
                    $query = $query->where('active', 'y')
                        ->where('id', '!=', $modality->id)
                        ->orderBy('order', 'asc');

                    return $query;
                })->first();
            }

            return view('site.modality.show', compact('modality', 'posts', 'modalityNext'));
        }

        return redirect()->route('service');
    }

}
