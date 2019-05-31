<?php

namespace AgenciaS3\Http\Controllers\Site;

use AgenciaS3\Entities\SeoPage;
use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\SiteRequest;
use AgenciaS3\Repositories\CategoryRepository;
use AgenciaS3\Repositories\ProductRepository;
use AgenciaS3\Repositories\SubCategoryRepository;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Facades\Route;

class CategoryController extends Controller
{

    protected $repository;

    protected $productRepository;

    protected $subCategoryRepository;

    public function __construct(CategoryRepository $repository,
                                ProductRepository $productRepository,
                                SubCategoryRepository $subCategoryRepository)
    {
        $this->repository = $repository;
        $this->productRepository = $productRepository;
        $this->subCategoryRepository = $subCategoryRepository;
    }

    public function index(SiteRequest $request, $seo_link)
    {
        $category = $this->repository->findWhere(['active' => 'y', 'seo_link' => $seo_link])->first();
        if($category) {
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

            $products = $this->productRepository->getCategory($category->id);

            return view('site.product.index', compact('search', 'products', 'category'));
        }

        return redirect()->route('product');
    }

    public function subcategory($seo_link, $sub_category)
    {
        $subCategory = $this->subCategoryRepository->findWhere(['active' => 'y', 'seo_link' => $sub_category])->first();
        if ($subCategory) {

            $products = $this->productRepository->getSubCategory($subCategory->id);

            return view('site.product.index', compact('search', 'products', 'subCategory'));
        }

        return redirect()->route('product');
    }

    public function getMenu()
    {
        return $this->repository
            ->orderBy('order', 'asc')
            ->findByField('active', 'y');
    }

    public function getSubCategoryMenu($category_id)
    {
        return $this->subCategoryRepository
            ->orderBy('order', 'asc')
            ->findWhere(['active' => 'y', 'category_id' => $category_id]);
    }

}
