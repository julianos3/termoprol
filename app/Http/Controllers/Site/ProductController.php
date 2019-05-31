<?php

namespace AgenciaS3\Http\Controllers\Site;

use AgenciaS3\Entities\SeoPage;
use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\SiteRequest;
use AgenciaS3\Repositories\ProductImageRepository;
use AgenciaS3\Repositories\ProductRepository;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Facades\Route;

class ProductController extends Controller
{

    protected $repository;

    protected $productImageRepository;

    public function __construct(ProductRepository $repository,
                                ProductImageRepository $productImageRepository)
    {
        $this->repository = $repository;
        $this->productImageRepository = $productImageRepository;
    }

    public function index(SiteRequest $request)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $search = $request->get('search');

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

        $products = $this->repository->getActive();

        return view('site.product.index', compact('search', 'products'));
    }

    public function show($seo_link)
    {
        $product = $this->repository->findWhere(['seo_link' => $seo_link, 'active' => 'y'])->first();
        if ($product) {

            $images = $this->productImageRepository->orderBy('order', 'asc')->findByField('product_id', $product->id);
            $image = $images->firstWhere('cover', 'y');

            $cover = asset('assets/store/images/logo_facebook.jpg');
            $cover2 = asset('assets/store/images/logo_facebook_2.jpg');
            if (isPost($image)) {
                $cover = asset('uploads/post/' . $image->image);
                $cover2 = $cover;
            }

            SEOMeta::setTitle($product->name);
            SEOMeta::setDescription($product->seo_description);
            SEOMeta::setCanonical(Route::getCurrentRequest()->getUri());
            SEOMeta::addKeyword([$product->seo_keywords]);
            TwitterCard::setTitle($product->name);
            TwitterCard::setDescription($product->seo_description);
            TwitterCard::addImage($cover);

            OpenGraph::setDescription($product->seo_description);
            OpenGraph::setTitle($product->name);
            OpenGraph::setUrl(Route::getCurrentRequest()->getUri());
            OpenGraph::addProperty('type', 'article');
            OpenGraph::addProperty('locale', 'pt-br');
            OpenGraph::addImage($cover, ['height' => 630, 'width' => 1200]);
            OpenGraph::addImage($cover);
            OpenGraph::addImage(['url' => $cover2, 'size' => 300]);
            OpenGraph::addImage($cover2, ['height' => 300, 'width' => 300]);

            $subCategory = $product->subCategory;

            return view('site.product.show', compact('product', 'images', 'subCategory'));
        }

        return redirect()->route('product');
    }

}
