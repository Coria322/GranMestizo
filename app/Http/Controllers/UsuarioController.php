<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:Usuario');
    }
    public function esUsuario()
    {
        return view('Cliente.main');
    }
    public function esAdmin()
    {
        return view('Admin.main');
    }
    public function esEmpleado()
    {
        return view('Empleado.main');
    }
}
