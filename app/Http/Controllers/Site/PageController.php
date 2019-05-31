<?php

namespace AgenciaS3\Http\Controllers\Site;

use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Repositories\PageImageRepository;
use AgenciaS3\Repositories\PageRepository;

class PageController extends Controller
{

    protected $repository;

    protected $pageImageRepository;

    public function __construct(PageRepository $repository,
                                PageImageRepository $pageImageRepository)
    {
        $this->repository = $repository;
        $this->pageImageRepository = $pageImageRepository;
    }

    public function show($id)
    {
        $this->repository->popCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        return $this->repository->find($id);
    }

    public function images($id)
    {
        $this->pageImageRepository->popCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        return $this->pageImageRepository->orderBy('order', 'asc')->findByField('page_id', $id);
    }
}
