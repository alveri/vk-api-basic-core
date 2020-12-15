<?php

namespace App\Common\Events;

use App\Common\DTO\HttpEvent;

class ProjectEvent
{
     /**
     * @var integer
     */
    private int $projectId;

    /**
     * @var HttpEvent
     */
    private HttpEvent $httpEvent;

    /**
     * @var string
     */
    private string $provider;

    /**
     * Create a new event instance.
     */
    public function __construct(int $projectId, HttpEvent $httpEvent, string $provider)
    {
        $this->projectId = $projectId;
        $this->httpEvent = $httpEvent;
        $this->provider = $provider;
    }
}
