<?php

namespace App\Engine;

use App\Engine\Repositories\EventFilterRepository;
use App\Engine\Events\ProjectEvent;

class EventFilterExtensionQueryBuilder
{
    /**
     * @var EventFilterRepository
     */
    private EventFilterRepository $repository;

    public function __construct(EventFilterRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllForEvent(ProjectEvent $projectEvent, $extensions)
    {
        $this->repository->resetCriteria();

        foreach ($extensions as $ext) {
            /**
             * @var $ext FilterSearchExtension
             */
            $criteria = $ext->createCriteria($event);
            if ($criteria) {
                $this->repository->pushCriteria($criteria);
            }
        }

        return $this->repository->all();
    }

}
