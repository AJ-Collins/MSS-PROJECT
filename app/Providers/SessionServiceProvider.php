<?php

namespace App\Providers;

use App\Session\DatabaseSessionHandler;
use Illuminate\Support\ServiceProvider;
use Illuminate\Session\SessionManager;

class SessionServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->resolving('session', function (SessionManager $manager) {
            $manager->extend('database', function ($app) {
                $connection = $app['config']['session.connection'];
                $table = $app['config']['session.table'];
                $lifetime = $app['config']['session.lifetime'];
                $connection = $app['db']->connection($connection);

                return new DatabaseSessionHandler(
                    $connection,
                    $table,
                    $lifetime,
                    $app
                );
            });

            return $manager;
        });
    }
}