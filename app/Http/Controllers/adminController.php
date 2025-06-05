<?php

namespace App\Http\Controllers;


use App\Models\Admin;
use App\Models\Empleado;
use App\Models\Mesa;
use App\Models\Platillo;
use App\Models\Usuario;
use App\Models\Reserva;
use Illuminate\Http\Request;

class adminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:Usuario');
        
    }

    public function home(Request $request)
    {
        $seccionActiva = $request->query('seccion', 'usuarios');

        $usuarios = Usuario::paginate(5);
        $mesas = Mesa::paginate(5);
        $empleados = Empleado::paginate(5);
        $reservas = Reserva::paginate(5);
        $platillos = Platillo::paginate(5);

        return view('admin.main', compact(
            'usuarios',
            'mesas',
            'empleados',
            'reservas',
            'seccionActiva',
            'platillos'
        ));
    }
}
