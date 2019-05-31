<?php

namespace AgenciaS3\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FindByCodeCriteria implements CriteriaInterface
{

    private $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('code', 'LIKE', "%{$this->code}%");
    }
}