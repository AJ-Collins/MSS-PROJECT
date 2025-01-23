<?php

namespace App\Providers;

use App\Traits\DynamicTitleTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    use DynamicTitleTrait;
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Paginator::useBootstrap();
        
        view()->composer('*', function ($view) {
            if (!isset($view->getData()['pageTitle'])) {
                $user = Auth::user();
                $currentRole = $user ? session('current_role', $user->roles->first()->name ?? 'guest') : 'guest';
                $pageTitle = $this->getPageTitle();
                $view->with([
                    'pageTitle' => $pageTitle,
                    'user' => Auth::user(),
                    'currentRole' => $currentRole,
                ]);
            }
        });
    }
}
