<?php

namespace App\Projects\Events;

use App\Projects\Project;
use Illuminate\Queue\SerializesModels;

class ProjectCreated
{

    /**
     * @var Project
     */
    public Project $project;

    /**
     * Create a new event instance.
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }
}
