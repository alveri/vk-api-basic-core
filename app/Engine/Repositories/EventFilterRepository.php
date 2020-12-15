<?php

namespace App\Engine\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Engine\Validators\EventFilterValidator;

class EventFilterRepository extends BaseRepository
{

    /**
     * @var array
     */
    protected array $fieldSearchable = [
        'projectId',
        'sectionId',
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return \App\Engine\Models\EventFilter::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator(): EventFilterValidator
    {
        return EventFilterValidator::class;
    }
}
