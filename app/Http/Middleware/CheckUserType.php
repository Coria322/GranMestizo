<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;;
use Illuminate\Http\Request;

class CheckUserType
{   
    public function handle(Request $request, Closure $next, $rol)
    {
    // dd('Middleware ejecutado', Auth::guard('Usuario')->check(), Auth::guard('Usuario')->user(), $rol);

    // dd(Auth::guard('Usuario')->user());
    if(!Auth::guard('Usuario')->check()){
        abort(403,'No estás autenticado');
    }

        // Si el usuario está autenticado pero su rol no coincide
    if (Auth::guard('Usuario')->user()->USUARIO_ROL != $rol) {
        abort(403,'No tienes permiso para acceder a este recurso');
    }
    

        return $next($request);
    }
    
}
