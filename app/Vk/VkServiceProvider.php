<?php


namespace App\Vk;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use VK\Client\VKApiClient;

class VkServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(VKApiClient::class, function (Application $app) {
            return new VKApiClient();
        });
    }
}
