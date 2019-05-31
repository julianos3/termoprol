<?php

namespace AgenciaS3\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FindByNameCriteria implements CriteriaInterface
{

    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('name', 'LIKE', "%{$this->name}%");
    }
}