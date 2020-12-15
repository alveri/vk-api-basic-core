<?php

namespace App\Engine\Listeners;

use Illuminate\Container\Container;
use App\Common\Events\ProjectEvent;
use App\Engine\Repositories\EventFilterRepository;
use App\Engine\EventFilterExtensionQueryBuilder;
use App\Engine\FilterSearchExtensions\VkGroupFilterSearchExtension;
use App\Common\VKConstants;

class Engine
{

    /**
    * @var EventFilterExtensionQueryBuilder
    */
    private EventFilterExtensionQueryBuilder $queryBuilder;

    /**
     * @var EventFilterRepository
     */
    private EventFilterRepository $eventRepo;


    public function __construct(EventFilterRepository $repo, EventFilterExtensionQueryBuilder $queryBuilder)
    {
        $this->eventRepo = $repo;
        $this->queryBuilder = $queryBuilder;
    }

    public function handle(ProjectEvent $event): void
    {
        $container = Container::getInstance();

        $extensions = \App::tagged('EngineSearchExtension');

        $events = $this->queryBuilder($event, $extensions);
    }


}
