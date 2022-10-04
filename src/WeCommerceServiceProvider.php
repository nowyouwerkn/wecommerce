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
            return view('front.theme.' . $this->theme->get_name() . '.auth.login');
        });

        Fortify::registerView(function () {
            return view('front.theme.' . $this->theme->get_name() . '.auth.register');
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('front.theme.' . $this->theme->get_name() . '.auth.forgot-password');
        });

         Fortify::resetPasswordView(function ($request) {
            return view('front.theme.' . $this->theme->get_name() . '.auth.reset-password', ['request' => $request]);
        });

        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'wecommerce');

        // Primera ruta es de donde viene el recurso a publicar y la segunda ruta en que parte se instalará.
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
        $this->publishes([
            __DIR__.'/database/seeders' => database_path('seeders/'),
        ], 'seeder_files');

        // Publica los comandos automatizados de Membresías
        $this->publishes([
            __DIR__.'/Console' => app_path('Console/'),
        ], 'commands');
    }
}
