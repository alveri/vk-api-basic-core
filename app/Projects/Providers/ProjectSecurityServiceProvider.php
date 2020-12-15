<?php

namespace App\Projects\Providers;

use Illuminate\Support\Facades\Gate;
use Auth;
use Illuminate\Support\ServiceProvider;
use App\Projects\ProjectMember;

class ProjectSecurityServiceProvider extends ServiceProvider
{

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        Gate::define('is-logged-in', function ($user) {
            return (!is_null(Auth::user()));
        });

        Gate::define('able-to-edit', function ($user, $projectId) {
            $roleMember = ProjectMember::where('projectId', $projectId)
                    ->where('userId', Auth::user()->id)->first();
            return(!is_null($roleMember) && 'admin' == $roleMember->role);
        });
    }
}
