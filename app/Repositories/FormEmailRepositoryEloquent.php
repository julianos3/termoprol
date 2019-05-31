<?php

namespace AgenciaS3\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use AgenciaS3\Repositories\FormEmailRepository;
use AgenciaS3\Entities\FormEmail;
use AgenciaS3\Validators\FormEmailValidator;

/**
 * Class FormEmailRepositoryEloquent.
 *
 * @package namespace AgenciaS3\Repositories;
 */
class FormEmailRepositoryEloquent extends BaseRepository implements FormEmailRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FormEmail::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return FormEmailValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
