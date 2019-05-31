<?php

namespace AgenciaS3\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use AgenciaS3\Repositories\LandingPageRepository;
use AgenciaS3\Entities\LandingPage;
use AgenciaS3\Validators\LandingPageValidator;

/**
 * Class LandingPageRepositoryEloquent.
 *
 * @package namespace AgenciaS3\Repositories;
 */
class LandingPageRepositoryEloquent extends BaseRepository implements LandingPageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LandingPage::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return LandingPageValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
