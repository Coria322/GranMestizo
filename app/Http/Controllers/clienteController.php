<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class clienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:Usuario');
    }

    public function panel(Request $request)
    {
        $seccionActiva = $request->query('seccion', 'inicio');
        $usuarioGlobal = Auth::guard('Usuario')->user();

        $reservasCliente = Reserva::where('CLIENTE_ID', $usuarioGlobal->USUARIO_ID)
            ->whereHas('reservasMesas', function ($query) {
                $query->where('STATUS', 'ACTIVO');  // Solo reservas con mesas activas
            })
            ->with(['reservasMesas' => function ($query) {
                $query->where('STATUS', 'ACTIVO');  // Cargar solo mesas activas
            }])
            ->orderBy('RESERVA_FECHA', 'desc')
            ->paginate(5);

        return view('Usuario.panelU', compact(
            'seccionActiva',
            'usuarioGlobal',
            'reservasCliente'
        ));
    }


    // NUEVO MÉTODO: Mostrar formulario de edición
    public function editarPerfil()
    {
        $usuarioGlobal = Auth::guard('Usuario')->user();
        return view('usuario.editCliente', compact('usuarioGlobal'));
    }

    // NUEVO MÉTODO: Actualizar perfil del cliente
    public function actualizarPerfil(Request $request)
    {
        $usuarioGlobal = Auth::guard('Usuario')->user();

        $request->validate([
            'USUARIO_NOMBRE' => 'required|string|max:50',
            'USUARIO_APELLIDO' => 'required|string|max:50',
            'USUARIO_CORREO' => 'required|email|unique:usuarios,USUARIO_CORREO,' . $usuarioGlobal->USUARIO_ID . ',USUARIO_ID',
            'USUARIO_FECHANAC' => 'nullable|date|before:today',
            'CLIENTE_RFC' => [
                'nullable',
                'string',
                'size:13',
                'regex:/^[A-Z]{4}[0-9]{6}[A-Z0-9]{3}$/',
                'unique:clientes,CLIENTE_RFC,' . $usuarioGlobal->USUARIO_ID . ',USUARIO_ID',
            ],
        ], [
            'CLIENTE_RFC.unique' => 'Este RFC ya está registrado por otro cliente.',
            'CLIENTE_RFC.regex' => 'El RFC debe tener un formato válido (4 letras, 6 dígitos, 3 caracteres alfanuméricos).',
            'CLIENTE_RFC.size' => 'El RFC debe tener exactamente 13 caracteres.',
        ]);

        // Actualiza los datos del usuario
        $usuarioGlobal->update([
            'USUARIO_NOMBRE' => $request->USUARIO_NOMBRE,
            'USUARIO_APELLIDO' => $request->USUARIO_APELLIDO,
            'USUARIO_CORREO' => $request->USUARIO_CORREO,
            'USUARIO_FECHANAC' => $request->USUARIO_FECHANAC,
        ]);

        // Actualiza el RFC si aplica
        if ($usuarioGlobal->cliente) {
            $usuarioGlobal->cliente->update([
                'CLIENTE_RFC' => $request->CLIENTE_RFC ?? null,
            ]);
        }

        return redirect()->route('Usuario.panelU', ['seccion' => 'perfil'])
            ->with('success', 'Perfil actualizado correctamente');
    }
}
