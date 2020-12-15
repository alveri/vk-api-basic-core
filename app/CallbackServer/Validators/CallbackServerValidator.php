<?php

namespace App\CallbackServer\Validators;

use \Prettus\Validator\LaravelValidator;

class CallbackServerValidator extends LaravelValidator {

    protected array $rules = [
        'projectId' => 'required|integer',
        'code'  => 'string|required',
        'data'=> 'array'
    ];

}
