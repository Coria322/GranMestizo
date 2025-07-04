<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    //*Middleware adicional para validar que se encuentra autenticado
    public function __construct()
    {
        $this->middleware('auth:Usuario')->except(['store']);
    }

    //* Métodos de validación para saber su tipo
    public function esUsuario()
    {
        return view('Usuario.panelU');
    }
    public function esAdmin()
    {
        return view('Admin.main');
    }
    public function esEmpleado()
    {
        return view('Empleado.panelP');
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
            : view('pruebas.index', compact('usuarios'));
    }

    // FORMULARIO DE CREACIÓN (solo admins)
    public function create()
    {
        return view('Registro.registroP');
    }

    // CREAR USUARIO (solo admins)
    public function store(Request $request)
    {
        //* Validar al usuario en la creación
        $request->validate([
            'USUARIO_NOMBRE' => 'required|string|max:50',
            'USUARIO_APELLIDO' => 'required|string|max:50',
            'USUARIO_CORREO' => 'required|email|unique:usuarios,USUARIO_CORREO',
            //uso del objeto password para validar la contraseña
            'USUARIO_PWD' =>
            [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'CLIENTE_RFC' => 'nullable|string|size:13|regex:/^[A-Z]{4}[0-9]{6}[A-Z0-9]{3}$/',
        ]);

        //*Crear al usuario
        $usuario = Usuario::create([
            'USUARIO_ID' => substr(Str::uuid()->toString(), 0, 10),
            'USUARIO_NOMBRE' => $request->USUARIO_NOMBRE,
            'USUARIO_APELLIDO' => $request->USUARIO_APELLIDO,
            'USUARIO_CORREO' => $request->USUARIO_CORREO,
            'USUARIO_FECHANAC' => $request->USUARIO_FECHANAC,
            'USUARIO_PWD' => $request->USUARIO_PWD,
            'USUARIO_ROL' => 'CLIENTE',

            //El rfc para el cliente o null.
            'CLIENTE_RFC' => $request->CLIENTE_RFC,
        ]);

        $usuario->cliente()->create([
            'CLIENTE_RFC' => $request->CLIENTE_RFC ?? null,

        ]);

        return redirect()->route('login')->with('success', 'Usuario Creado correctamente');
    }

    public function show($id)
    {
        $usuario = Usuario::with([
            'cliente.reservas',
            'empleado.reservas',
            'administrador'
        ])->findOrFail($id);

        $authUser = Auth::guard('Usuario')->user();

        $usuario->perfil();
        // Verificar si el usuario autenticado es un administrador
        // O si el usuario autenticado es el mismo que el usuario que se está mostrando
        if ($authUser->USUARIO_ROL != 'ADMINISTRADOR' && $authUser->USUARIO_ID != $usuario->USUARIO_ID) {
            abort(403, 'Acceso no autorizado');
        }

        return view('detalleUsuario', compact('usuario'));
    }

    // EDITAR USUARIO (solo admins) o el mismo usuario
    public function edit($id)
    {
        if (Auth::guard('Usuario')->user()->USUARIO_ROL != 'ADMINISTRADOR' && Auth::guard('Usuario')->user()->USUARIO_ID != $id) {
            abort(403, 'No puedes editar este usuario.');
        }

        $usuario = Usuario::findOrFail($id);

        return view('usuario.edit', compact('usuario'));
    }


    // ACTUALIZAR USUARIO (solo admins) o el mismo usuario
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        $authUser = Auth::guard('Usuario')->user();

        // Solo el admin o el mismo usuario puede editar
        if ($authUser->USUARIO_ROL != 'ADMINISTRADOR' && $authUser->USUARIO_ID != $usuario->USUARIO_ID) {
            abort(403, 'No puedes editar este usuario.');
        }

        // Validaciones
        $request->validate([
            'USUARIO_NOMBRE' => 'required|string|max:50',
            'USUARIO_APELLIDO' => 'required|string|max:50',
            'USUARIO_CORREO' => 'required|email|unique:usuarios,USUARIO_CORREO,' . $usuario->USUARIO_ID . ',USUARIO_ID',
            'USUARIO_ROL' => 'nullable|string|in:ADMINISTRADOR,EMPLEADO,CLIENTE', // Solo válida si viene de un admin
            'CLIENTE_RFC' => 'nullable|string|size:13',
            'EMPLEADO_RFC' => 'nullable|string|size:13',
        ]);

        // Solo el admin puede cambiar el rol
        if ($authUser->USUARIO_ROL == 'ADMINISTRADOR') {
            $usuario->USUARIO_ROL = $request->USUARIO_ROL ?? $usuario->USUARIO_ROL;
        }

        // Actualización normal
        $usuario->update([
            'USUARIO_NOMBRE' => $request->USUARIO_NOMBRE,
            'USUARIO_APELLIDO' => $request->USUARIO_APELLIDO,
            'USUARIO_CORREO' => $request->USUARIO_CORREO,
            // USUARIO_ROL se asignó arriba si es admin
        ]);

        //Actualizar por roles
        if ($usuario->USUARIO_ROL == 'CLIENTE') {
            $usuario->cliente()->update([
                'CLIENTE_RFC' => $request->CLIENTE_RFC ?? null,
            ]);
        } elseif ($usuario->USUARIO_ROL == 'EMPLEADO') {
            $usuario->empleado()->update([
                'EMPLEADO_RFC' => $request->EMPLEADO_RFC ?? null,
                'EMPLEADO_TURNO' => $request->EMPLEADO_TURNO ?? 'M',
                'EMPLEADO_STATUS' => $request->EMPLEADO_STATUS ?? 'ACTIVO',
            ]);
        }

        return redirect()->route('login')->with('success', 'Usuario actualizado correctamente.');
    }

    // Cambiar el rol de un usuario (solo admin)
    public function cambiarRol(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        $authUser = Auth::guard('Usuario')->user();

        if ($authUser->USUARIO_ROL != 'ADMINISTRADOR') {
            abort(403, 'No tienes permisos para cambiar el rol.');
        }

        $request->validate([
            'nuevo_rol' => 'required|in:CLIENTE,EMPLEADO,ADMINISTRADOR',
            'CLIENTE_RFC' => 'nullable|string|size:13',
            'EMPLEADO_RFC' => 'nullable|string|size:13',
        ]);

        // Eliminar relaciones anteriores
        match ($usuario->USUARIO_ROL) {
            'CLIENTE' => $usuario->cliente()?->delete(),
            'EMPLEADO' => $usuario->empleado()?->delete(),
            'ADMINISTRADOR' => $usuario->administrador()?->delete(),
        };

        // Cambiar el rol
        $usuario->USUARIO_ROL = $request->nuevo_rol;
        $usuario->save();


        // Crear la nueva relación
        match ($request->nuevo_rol) {
            'CLIENTE' => $usuario->cliente()->create([
                'CLIENTE_RFC' => $request->CLIENTE_RFC ?? null
            ]),

            'EMPLEADO' => $usuario->empleado()->create([
                'EMPLEADO_RFC' => $request->EMPLEADO_RFC ?? null,
                'EMPLEADO_TURNO' => $request->EMPLEADO_TURNO ?? 'M',
                'EMPLEADO_STATUS' => $request->EMPLEADO_STATUS ?? 'LIBRE',
            ]),
            'ADMINISTRADOR' => $usuario->administrador()->create([
                'USUARIO_ID' => $usuario->USUARIO_ID,
            ]),
        };

        //login lo mandará a su panel
        return redirect()->route('login')->with('success', 'Rol cambiado correctamente');
    }

    public function destroy($id)
    {
        $user = Auth::guard('Usuario')->user();

        if ($user->USUARIO_ROL != 'ADMINISTRADOR') {
            abort(403, 'Acceso no autorizado');
        }

        $usuario = Usuario::findOrFail($id);

        // Validación de reservas activas en mesas para EMPLEADO
        if ($usuario->USUARIO_ROL == 'EMPLEADO' && $usuario->empleado && $usuario->empleado->tieneReservasActivasEnMesas()) {
            return redirect()
                ->route('admin.main', ['seccion' => 'usuarios'])
                ->with('error', 'No se puede eliminar el usuario porque tiene reservas activas asociadas a mesas.');
        }


        $usuario->delete();

        return redirect()
            ->route('admin.main', ['seccion' => 'usuarios'])
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
