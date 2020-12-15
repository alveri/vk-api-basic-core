<?php

namespace App\Projects\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class ProjectRepository extends BaseRepository
{

    /**
     * @var array
     */
    protected array $fieldSearchable = [
        'name'
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return \App\Projects\Project::class;
    }

    public function boot(): void
    {
        $this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
    }
}
