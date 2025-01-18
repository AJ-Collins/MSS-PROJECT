<?php

namespace App\Providers;

use App\Traits\DynamicTitleTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;
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
                $currentRole = $this->getCurrentUserRole();
                $pageTitle = $this->getPageTitle();
                $user = Auth::user();
                $view->with([
                    'pageTitle' => $pageTitle,
                    'user' => Auth::user()
                ]);
            }
        });
    }
}
