<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('view-admin-dashboard', function ($user) {
            return $user->hasRole('admin');
        });

        Gate::define('view-user-dashboard', function ($user) {
            return $user->hasRole('user');
        });

        Gate::define('view-reviewer-dashboard', function ($user) {
            return $user->hasRole('reviewer');
        });
    }
}