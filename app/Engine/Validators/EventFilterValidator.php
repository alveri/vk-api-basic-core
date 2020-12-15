<?php

namespace App\Engine\Validators;

use \Prettus\Validator\LaravelValidator;

class EventFilterValidator extends LaravelValidator {

    protected array $rules = [
        'projectId' => 'required|integer',
        'sectionId'  => 'integer|required',
        'data'=> 'array'
    ];

}
