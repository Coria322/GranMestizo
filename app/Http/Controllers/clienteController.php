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
}