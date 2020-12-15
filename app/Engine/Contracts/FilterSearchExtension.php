<?php

namespace App\Engine\Contracts;

// TODO ????
use App\Engine\Events\ProjectEvent;

interface FilterSearchExtension
{
    public function createCriteria(ProjectEvent $event);

}
