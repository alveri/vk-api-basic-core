<?php

namespace App\Engine\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class VkGroupFilterExtensionRepository extends BaseRepository
{

    /**
     * @var array
     */
    protected array $fieldSearchable = [
        'projectId',
        'eventFilterId',
        'groupId',
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return \App\Engine\Models\VkGroupFilterExtension::class;
    }

}
