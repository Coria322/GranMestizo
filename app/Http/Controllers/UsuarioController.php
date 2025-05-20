<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    //*Middleware adicional para validar que se encuentra autenticado
    public function __construct()
    {
        $this->middleware('auth:Usuario');
    }

    //* Métodos de validación para saber su tipo
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

    //* Métodos CRUD
    //* Consulta todos los Usuarios (requiere admin)
    public function index()
    {
        //* Obtener el usuario autenticado
        $user = Auth::guard('Usuario')->user();

        //* Validar que el usuario es un administrador
        if ($user->USUARIO_ROL != 'ADMINISTRADOR') {
            abort(403, 'Acceso no autorizado');
        }

        //* Recuperar todos los usuarios con sus relaciones por rol
        $usuarios = Usuario::all();

        return request()->wantsJson()
        ? response()->json($usuarios)
        : view('usuariosindex', compact('usuarios'));
    }

        // FORMULARIO DE CREACIÓN (solo admins)
        //TODO terminar los action de crud
    public function create()
    {
        if (Auth::guard('Usuario')->user()->USUARIO_ROL != 'ADMINISTRADOR') {
            abort(403, 'Solo los administradores pueden crear usuarios.');   
        }

        //TODO hacer vista
        return view('usuarios.create');
    }

    public function store(Request $request){
        $request->validate([
            'USUARIO_NOMBRE' => 'required|string|max:50',
            
        ]);
    }

}
