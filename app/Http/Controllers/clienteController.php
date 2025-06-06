<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class clienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:Usuario');
    }

    public function panel(Request $request)
    {
        // Obtener la sección activa (igual que el empleado)
        $seccionActiva = $request->query('seccion', 'inicio');

        // Obtener el usuario global (cliente logueado)
        $usuarioGlobal = auth()->user();
        
        // Obtener reservaciones del cliente logueado
        $reservasCliente = Reserva::where('CLIENTE_ID', $usuarioGlobal->USUARIO_ID)
                                 ->with(['reservasMesas'])
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
        $usuarioGlobal = auth()->user();
        return view('usuario.editCliente', compact('usuarioGlobal'));
    }

    // NUEVO MÉTODO: Actualizar perfil del cliente
    public function actualizarPerfil(Request $request)
    {
        $usuarioGlobal = auth()->user();
        
        $request->validate([
            'USUARIO_NOMBRE' => 'required|string|max:50',
            'USUARIO_APELLIDO' => 'required|string|max:50',
            'USUARIO_CORREO' => 'required|email|unique:usuarios,USUARIO_CORREO,' . $usuarioGlobal->USUARIO_ID . ',USUARIO_ID',
            'USUARIO_FECHANAC' => 'nullable|date|before:today',
            'CLIENTE_RFC' => 'nullable|string|size:13|regex:/^[A-Z]{4}[0-9]{6}[A-Z0-9]{3}$/',
        ]);

        $usuarioGlobal->update([
            'USUARIO_NOMBRE' => $request->USUARIO_NOMBRE,
            'USUARIO_APELLIDO' => $request->USUARIO_APELLIDO,
            'USUARIO_CORREO' => $request->USUARIO_CORREO,
            'USUARIO_FECHANAC' => $request->USUARIO_FECHANAC,
        ]);

        // Actualizar RFC del cliente
        if ($usuarioGlobal->cliente) {
            $usuarioGlobal->cliente->update([
                'CLIENTE_RFC' => $request->CLIENTE_RFC ?? null,
            ]);
        }

        return redirect()->route('Usuario.panelU', ['seccion' => 'perfil'])
                         ->with('success', 'Perfil actualizado correctamente');
    }
}