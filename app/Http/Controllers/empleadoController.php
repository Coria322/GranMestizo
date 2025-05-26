<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Reserva;
use Illuminate\Http\Request;
use App\Models\Mesa;
use App\Models\Usuario;

class empleadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:Usuario');
    }

    public function panelP(Request $request)
    {
        // Obtener la sección activa (igual que el admin pero con default 'reservaciones')
        $seccionActiva = $request->query('seccion', 'reservaciones');

        // Obtener el usuario global (empleado logueado)
        $usuarioGlobal = auth()->user();
        
        // Obtener datos del empleado
        $empleado = Empleado::where('USUARIO_ID', $usuarioGlobal->USUARIO_ID)->first();
        
        // Obtener reservas paginadas (puedes filtrar por empleado si es necesario)
        $reservas = Reserva::with(['cliente', 'reservasMesas'])
                           ->paginate(5);

        return view('Empleado.panelP', compact(
            'seccionActiva',
            'usuarioGlobal', 
            'empleado',
            'reservas'
        ));
    }
}