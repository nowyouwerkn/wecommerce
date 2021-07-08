<?php

namespace Nowyouwerkn\WeCommerce;

use Illuminate\Support\ServiceProvider;

class WeCommerceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\DashboardController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\FrontController');
        $this->loadViewsFrom(__DIR__.'/views', 'wecommerce');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/nowyouwerkn/wecommerce/src/assets'),
        ], 'public');
    }
}
