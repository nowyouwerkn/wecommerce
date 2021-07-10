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

        // Primera ruta es de donde viene el recurso a publicar y la segunda ruta en que parte se instalará.
        $this->publishes([
            __DIR__.'/views/front' => resource_path('views/front/theme/'),
        ]);

        // Publicar Assets de Estilos
        $this->publishes([
            __DIR__.'/assets' => public_path(''),
        ], 'public');

        // Publicar archivos de config
        $this->publishes([
            __DIR__.'/config' => config_path(''),
        ]);
    }
}
