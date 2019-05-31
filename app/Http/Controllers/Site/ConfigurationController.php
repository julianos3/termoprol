<?php

namespace AgenciaS3\Http\Controllers\Site;

use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Repositories\ConfigurationRepository;

class ConfigurationController extends Controller
{

    protected $repository;


    public function __construct(ConfigurationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function show($id)
    {
        $this->repository->popCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        return $this->repository->find($id);
    }

}
