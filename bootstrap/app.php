<?php

use App\Http\Middleware\CheckUserType;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    /**
     * Define los parametros de enrutamiento de la aplicación, incluyendo
     * las rutas web, API, comandos de consola y la ruta de salud.
     */
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    /**
     * Define el middeware de verificación de tipo de usuario.
     * Este middleware se encargará de verificar el tipo de usuario
     * antes de permitir el acceso a ciertas rutas o recursos.
     */
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'check' => CheckUserType::class
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
