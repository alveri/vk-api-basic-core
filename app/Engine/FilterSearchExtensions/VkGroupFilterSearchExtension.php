<?php

namespace App\Engine\FilterSearchExtensions;

use App\Engine\Contracts\FilterSearchExtension;
use App\CallbackServer\Events\ProjectEvent;
use App\Engine\Criterias\VkGroupEventCriteria;
use App\Engine\Repositories\VkGroupFilterExtensionRepository;
use App\Common\VKConstants;

class VkGroupFilterSearchExtension implements FilterSearchExtension
{
    public function createCriteria(ProjectEvent $event): VkGroupEventCriteria
    {
        $body = json_decode($event->httpEvent->body, true);
        if (array_key_exists(VKConstants::VK_GROUP_PROVIDER, $body)) {
             return null;
        }
        return new VkGroupEventCriteria($event);
    }
}
