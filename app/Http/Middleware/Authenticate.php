<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use illuminate\Auth\Middleware\Authenticate as Middleware;


class Authenticate extends Middleware
{
    public function redirectTo(Request $request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }
}
