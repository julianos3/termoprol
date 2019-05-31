<?php

namespace AgenciaS3\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use AgenciaS3\Repositories\LandingPageContactRepository;
use AgenciaS3\Entities\LandingPageContact;
use AgenciaS3\Validators\LandingPageContactValidator;

/**
 * Class LandingPageContactRepositoryEloquent.
 *
 * @package namespace AgenciaS3\Repositories;
 */
class LandingPageContactRepositoryEloquent extends BaseRepository implements LandingPageContactRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LandingPageContact::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return LandingPageContactValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
