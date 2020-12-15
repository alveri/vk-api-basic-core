<?php

namespace App\Engine\Criterias;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;
// TODO ???
use App\Engine\Events\ProjectEvent;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;

class VkGroupEventCriteria implements CriteriaInterface
{
    /**
     * @var ProjectEvent
     */
    private ProjectEvent $projectEvent;

    public function __construct(ProjectEvent $projectEvent)
    {
        $this->projectEvent = $projectEvent;
    }


    public function apply($model, RepositoryInterface $repository): Model
    {
        $data = json_decode($this->projectEvent->httpEvent->body());
        $model = $model->whereIn('id', function (Builder $query) use ($data) {
            // TODO Use $model -> table
           $query->from('vk_group_filters_extension')
               ->select('eventFilterId')
               ->where('groupId', $data['group_id']);
        });
        return $model;
    }
}
