<?php

namespace App\Identity\Providers;

use App\Identity\AuthUserProvider;
use App\Identity\Models\User;
use App\Identity\UniqUserNameObserver;
use Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class IdentityServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected  $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Auth::provider('identity-users', function ($app, $config) {
            return new AuthUserProvider();
        });

        User::observe(UniqUserNameObserver::class);
    }
}
