<?php

namespace Nowyouwerkn\WeCommerce;

use Illuminate\Support\ServiceProvider;

use Nowyouwerkn\WeCommerce\Models\StoreTheme;

/* Fortify Auth */
use Nowyouwerkn\WeCommerce\Responses\LoginResponse;
use Laravel\Fortify\Fortify;

class WeCommerceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\BannerController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\CartController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\CategoryController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\CityController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\ClientController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\CountryController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\CouponController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\CurrencyController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\DashboardController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\ExampleController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\FrontController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\InstallController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\LegalTextController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\MailController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\NotificationController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\OrderController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\OrderNoteController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\PaymentMethodController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\ProductController');       
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\ProductVariantController'); 
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\ReviewController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\SearchController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\SEOController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\ShipmentMethodController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\StateController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\StockController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\StoreConfigController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\StoreTaxController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\UserController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\VariantController');
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\WishlistController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {   
        $this->theme = new StoreTheme;

        // Vistas de autenticación usando Fortify
        Fortify::loginView(function () {
            return view('front.theme.' . $this->theme->get_name() . '.auth');
        });

        Fortify::registerView(function () {
            return view('front.theme.' . $this->theme->get_name() . '.auth');
        });

        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);

        /*
        if ($this->app->runningInConsole()) {
            $this->publishResources();
        }
        */

        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'wecommerce');

        // Primera ruta es de donde viene el recurso a publicar y la segunda ruta en que parte se instalará.
        $this->publishes([
            __DIR__.'/resources/views/front' => resource_path('views/front/theme/'),
        ], 'theme');

        // Primera ruta es de donde viene el recurso a publicar y la segunda ruta en que parte se instalará.
        $this->publishes([
            __DIR__.'/resources/views/errors' => resource_path('views/errors'),
        ], 'error-views');

        // Publica los archivos de traducción del sistema
        $this->publishes([
            __DIR__.'/resources/lang' => resource_path('lang/'),
        ], 'translations');

        // Publicar Assets de Estilos
        $this->publishes([
            __DIR__.'/assets' => public_path(''),
        ], 'public');

        // Publicar archivos de config
        $this->publishes([
            __DIR__.'/config' => config_path(''),
        ], 'config');

        // Publicar archivos de base de datos
        $this->publishes([
            __DIR__.'/database/migrations' => database_path('migrations/'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/database/seeders' => database_path('seeders/'),
        ], 'seeders');
    }

    /*
    protected function publishResources()
    {
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

        // Publicar archivos de base de datos
        $this->publishes([
            __DIR__.'/database/migrations' => database_path('migrations/'),
        ]);
        $this->publishes([
            __DIR__.'/database/seeders' => database_path('seeders/'),
        ]);
    }
    */
}
