<?php

namespace AgenciaS3\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use AgenciaS3\Repositories\PageRepository;
use AgenciaS3\Entities\Page;
use AgenciaS3\Validators\PageValidator;

/**
 * Class PageRepositoryEloquent.
 *
 * @package namespace AgenciaS3\Repositories;
 */
class PageRepositoryEloquent extends BaseRepository implements PageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Page::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PageValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
