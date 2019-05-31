<?php

namespace AgenciaS3\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use AgenciaS3\Repositories\LandingPageProductRepository;
use AgenciaS3\Entities\LandingPageProduct;
use AgenciaS3\Validators\LandingPageProductValidator;

/**
 * Class LandingPageProductRepositoryEloquent.
 *
 * @package namespace AgenciaS3\Repositories;
 */
class LandingPageProductRepositoryEloquent extends BaseRepository implements LandingPageProductRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LandingPageProduct::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return LandingPageProductValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
