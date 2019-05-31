<?php

namespace AgenciaS3\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FindByIdCriteria implements CriteriaInterface
{

    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        if(isset($this->id)) {
            return $model->where('id', $this->id);
        }

        return $model;
    }
}