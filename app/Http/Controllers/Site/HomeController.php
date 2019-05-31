<?php

namespace AgenciaS3\Http\Controllers\Site;

use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Http\Requests\SiteRequest;
use AgenciaS3\Repositories\BannerMobileRepository;
use AgenciaS3\Repositories\BannerRepository;

class HomeController extends Controller
{

    protected $bannerRepository;

    protected $bannerMobileRepository;

    public function __construct(BannerRepository $bannerRepository,
                                BannerMobileRepository $bannerMobileRepository)
    {
        $this->bannerRepository = $bannerRepository;
        $this->bannerMobileRepository = $bannerMobileRepository;
    }

    public function index(SiteRequest $request)
    {
        //$seoPage = SeoPage::find(1);
        //(new SEOService)->getPage($seoPage);

        $banners = $this->bannerRepository->orderBy('order', 'asc')->showStore(3);
        $bannerMobile = $this->bannerMobileRepository->showStore(1);

        return view('site.home.index', compact('banners', 'bannerMobile'));
    }

}
