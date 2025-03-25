<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Configuraciones para entorno local
        if ($this->app->isLocal()) {
            // Registrar proveedores específicos para desarrollo
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Configuración para longitudes de cadena en MySQL/MariaDB antiguos
        Schema::defaultStringLength(191);

        // 2. Compartir variables con todas las vistas
        View::composer('*', function ($view) {
            $view->with([
                'sidebarWidth' => config('sidebar.width', 260),
                'primaryColor' => config('colors.primary', '#45247b'),
                'currentUser' => auth()->user()
            ]);
        });

        // 3. Configurar el estilo de paginación (Bootstrap para Tabler)
        Paginator::useBootstrap();

        // 4. Configuración adicional para el tema
        $this->configureTheme();
    }

    protected function configureTheme(): void
    {
        // Personalización de colores
        config([
            'colors.primary' => '#45247b',
            'colors.secondary' => '#6d4a9e',
            'sidebar' => [
                'width' => 260,
                'collapsed' => 80
            ]
        ]);
    }
}