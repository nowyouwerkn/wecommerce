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
            __DIR__.'/../views/front' => resource_path('views/front/theme/'),
        ]);

        // Publicar Assets
        $this->publishes([
            __DIR__.'/../assets' => public_path('/assets'),
        ], 'public');
    }
}
