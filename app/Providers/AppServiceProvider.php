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
        View::composer('*', function (\Illuminate\View\View $view) {
            /** @var \App\Models\Usuario|null $usuario */
            $usuario = Auth::guard('Usuario')->user();

            if ($usuario) {
                $usuario->perfil(); // Carga el perfil correspondiente
            }

            $view->with('usuario', $usuario);
        });
    }
}
