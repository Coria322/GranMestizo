<?php

namespace App\Http\Controllers;

use App\Models\Platillo;
use Illuminate\Http\Request;

class bienvenidaController extends Controller
{
    public function index(){
        $platillos = Platillo::where('PLATILLO_STATUS', 'activo')->get();
        return view("bienvenida", compact("platillos"));
    }
}
