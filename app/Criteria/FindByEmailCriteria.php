<?php

namespace AgenciaS3\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FindByEmailCriteria implements CriteriaInterface
{

    private $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('email', 'LIKE', "%{$this->email}%");
    }
}