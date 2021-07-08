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
        $this->loadViewsFrom(__DIR__.'/views', 'wecommerce');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('vendor/nowyouwerkn/wecommerce/src/views/front/werkn-backbone'),
        ]);

        // Publicar Assets
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/nowyouwerkn/wecommerce/src/assets'),
        ], 'public');
    }
}
