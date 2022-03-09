<?php

namespace Nowyouwerkn\WeCommerce;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator; 
use Illuminate\Pagination\LengthAwarePaginator;

use Nowyouwerkn\WeCommerce\Models\StoreTheme;

/* Fortify Auth */
use Laravel\Fortify\Fortify;
use Nowyouwerkn\WeCommerce\Services\Auth\CreateNewUser as NewUser;

use Nowyouwerkn\WeCommerce\Responses\LoginResponse;

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
        $this->app->make('Nowyouwerkn\WeCommerce\Controllers\CouponController');
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
        // Permitir paginación para Colecciones (se utiliza en FrontController)
        if (!Collection::hasMacro('paginate')) {

            Collection::macro('paginate', 
                function ($perPage = 15, $page = null, $options = []) {
                $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
                return (new LengthAwarePaginator(
                    $this->forPage($page, $perPage)->values()->all(), $this->count(), $perPage, $page, $options))
                    ->withPath('');
            });
        }

        // Utilizar estilos de Bootstrap en la paginación
        Paginator::useBootstrap();

        // Definir el Tema Usado en el Sistema
        $this->theme = new StoreTheme;

        // Vistas de autenticación usando Fortify
        Fortify::createUsersUsing(NewUser::class);

        Fortify::loginView(function () {
            return view('front.theme.' . $this->theme->get_name() . '.auth');
        });

        Fortify::registerView(function () {
            return view('front.theme.' . $this->theme->get_name() . '.auth');
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('front.theme.' . $this->theme->get_name() . '.authforget');
        });

         Fortify::resetPasswordView(function () {
            return view('front.theme.' . $this->theme->get_name() . '.authreset', ['request' => $request]);
        });

        // Redirección personalizada en Fortify
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
        /*
        $this->publishes([
            __DIR__.'/resources/views/front/werkn-backbone' => resource_path('views/front/theme/werkn-backbone/'),
        ], 'werkn-theme');
        */
        
        $this->publishes([
            __DIR__.'/resources/views/front/werkn-backbone-bootstrap' => resource_path('views/front/theme/werkn-backbone-bootstrap/'),
        ], 'werkn-bootstrap');

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
        ], 'styles');

        // Publicar archivos de config
        $this->publishes([
            __DIR__.'/config' => config_path(''),
        ], 'config_files');

        // Publicar archivos de base de datos
        /*
        $this->publishes([
            __DIR__.'/database/migrations' => database_path('migrations/'),
        ], 'migration_files');
        */
        
        $this->publishes([
            __DIR__.'/database/seeders' => database_path('seeders/'),
        ], 'seeder_files');
    }

    /*
    protected function publishResources()
    {
        // Primera ruta es de donde viene el recurso a publicar y la segunda ruta en que parte se instalará.
        $this->publishes([
            __DIR__.'/resources/views/front' => resource_path('views/front/theme/'),
        ], 'theme_views');

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
        ], 'styles');

        // Publicar archivos de config
        $this->publishes([
            __DIR__.'/config' => config_path(''),
        ], 'config_files');

        // Publicar archivos de base de datos
        $this->publishes([
            __DIR__.'/database/migrations' => database_path('migrations/'),
        ], 'migration_files');

        $this->publishes([
            __DIR__.'/database/seeders' => database_path('seeders/'),
        ], 'seeder_files');
    }
    */
}
