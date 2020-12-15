<?php

namespace App\Identity;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Model;

class ConnectionCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository): Model
    {
        return $model;
    }
}
