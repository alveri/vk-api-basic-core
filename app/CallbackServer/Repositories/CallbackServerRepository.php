<?php

namespace App\CallbackServer\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\CallbackServer\Validators\CallbackServerValidator;

class CallbackServerRepository extends BaseRepository
{

    /**
     * @var array
     */
    protected array $fieldSearchable = [
        'code',
        'projectId'
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return \App\CallbackServer\Models\CallbackServer::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator(): CallbackServerValidator
    {
        return CallbackServerValidator::class;
    }

}
