<?php

namespace App\Engine\Contracts;

use App\Engine\Models\EventFilter;

interface FilterPlugin
{
    public function eventFilterCreated(EventFilter $filter);

    public function eventFilterRemoved(EventFilter $filter);

}
