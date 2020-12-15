<?php

namespace App\Engine\Providers;

use Carbon\Laravel\ServiceProvider;
use App\Engine\Plugins\VkGroupFilterPlugin;
use App\Engine\FilterSearchExtensions\VkGroupFilterSearchExtension;

class EngineServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->singleton(VkGroupFilterPlugin::class);

        $this->app->singleton(VkGroupFilterSearchExtension::class);

        $this->app->tag(VkGroupFilterSearchExtension::class, 'EngineSearchExtension');

    }
}
