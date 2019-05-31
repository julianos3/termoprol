<?php

namespace AgenciaS3\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use AgenciaS3\Repositories\ConfigurationRepository;
use AgenciaS3\Entities\Configuration;
use AgenciaS3\Validators\ConfigurationValidator;

/**
 * Class ConfigurationRepositoryEloquent.
 *
 * @package namespace AgenciaS3\Repositories;
 */
class ConfigurationRepositoryEloquent extends BaseRepository implements ConfigurationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Configuration::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ConfigurationValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
