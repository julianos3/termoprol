<?php

namespace AgenciaS3\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use AgenciaS3\Repositories\PageImageRepository;
use AgenciaS3\Entities\PageImage;
use AgenciaS3\Validators\PageImageValidator;

/**
 * Class PageImageRepositoryEloquent.
 *
 * @package namespace AgenciaS3\Repositories;
 */
class PageImageRepositoryEloquent extends BaseRepository implements PageImageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PageImage::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PageImageValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
