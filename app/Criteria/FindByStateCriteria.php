<?php

namespace AgenciaS3\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FindByStateCriteria implements CriteriaInterface
{

    private $state_id;

    public function __construct($state_id)
    {
        $this->state_id = $state_id;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        if (isPost($this->state_id)) {
            return $model->where('state_id', $this->state_id);
        }

        return $model;
    }
}