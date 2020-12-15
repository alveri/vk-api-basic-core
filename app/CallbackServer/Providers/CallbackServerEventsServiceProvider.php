<?php

namespace App\CallbackServer\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class CallbackServerEventsServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Projects\Events\ProjectCreated::class => [
            \App\CallbackServer\Listeners\CallbackServerCreating::class,
        ],
        \App\Tokens\Events\TokenCreated::class => [
            \App\CallbackServer\Listeners\CallbackServerLinking::class,
        ],
        \App\CallbackServer\Events\CallbackServerConfirmationEvent::class => [
            \App\CallbackServer\Listeners\CallbackServerConfirmation::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();

        //
    }
}
