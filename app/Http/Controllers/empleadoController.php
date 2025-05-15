<?php

namespace App\Http\Controllers;

use GuzzleHttp\Middleware;
use Illuminate\Http\Request;

class empleadoController extends Controller
{
    //
    public function __construct(){
        $this->middleware('Auth:Usuario');
    }
}
