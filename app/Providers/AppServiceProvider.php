<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Service Provider base de Laravel.
// Es un punto global para registrar configuraciones o servicios.
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // register(): se usa para enlazar servicios en el contenedor de Laravel.
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // boot(): se ejecuta al arrancar la aplicacion.
        // Aqui podrias poner ajustes globales de modelos, validaciones, etc.
        //
    }
}
