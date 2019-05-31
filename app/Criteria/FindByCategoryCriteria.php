<?php

namespace AgenciaS3\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FindByCategoryCriteria implements CriteriaInterface
{

    private $category_id;

    public function __construct($category_id)
    {
        $this->category_id = $category_id;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('category_id', $this->category_id);
    }
}