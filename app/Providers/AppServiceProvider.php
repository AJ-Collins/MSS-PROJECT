<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Traits\DynamicTitleTrait;

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
        view()->composer('*', function ($view) {
            if (!isset($view->getData()['pageTitle'])) {
                $currentRole = $this->getCurrentUserRole();
                $pageTitle = $this->getPageTitle();
                $view->with('pageTitle', $pageTitle);
            }
        });
    }
}
