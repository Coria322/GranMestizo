<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Usuario;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /*
         *Este bloque de código en boot crea una variable global "usuario"
         *Esto permite acceder facilmente al usuario autenticado y realizar
         *operaciones relacionadas a la base de datos  
         */
        View::composer('*', function (\Illuminate\View\View $view) {
            /** @var \App\Models\Usuario|null $usuarioGlobal */
            $usuarioGlobal = Auth::guard('Usuario')->user();

            if ($usuarioGlobal) {
                $usuarioGlobal->perfil(); // Carga el perfil correspondiente
            }

            $view->with('usuario', $usuarioGlobal);
        });
    }
}
