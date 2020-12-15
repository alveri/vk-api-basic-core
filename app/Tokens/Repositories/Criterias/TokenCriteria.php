<?php

namespace App\Tokens\Repositories\Criterias;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Model;

class TokenCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository): Model
    {
        return $model;
    }
}
