<?php

namespace App\Engine;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\App;
use App\Engine\Plugins\VkGroupFilterPlugin;
use App\Common\VKConstants;

class PluginEngine
{
    public $plugin;

    public function __construct($provider)
    {
        switch ($provider) {
            case VKConstants::VK_GROUP_PROVIDER:
                $this->plugin = resolve(VkGroupFilterPlugin::class);
                break;
        }
    }
}
