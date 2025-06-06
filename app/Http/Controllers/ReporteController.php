<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Reporte;

class ReporteController extends Controller
{
    public function __construct(){
        $this->middleware("auth:Usuario");
    }

    public function store(Request $request, $id){
        try{
            $validated = $request->validate([
                'Contenido'=> 'required|string|max:255',
                
            ]);

            Reporte::create([
                'REPORTE_ID' => 'REP_' . strtoupper(substr(Str::uuid()->toString(),0,6)),
                'USUARIO_ID' => $id,
                'REPORTE_CONTENIDO' => $validated['Contenido'],
            ]);

        }catch(Exception ){
            return back()->with('error', 'Error al realizar su reporte');
        }
        return back()->with('success','Reporte realizado correctamente');
    }

    public function show($id){
        $reporte = Reporte::with(
            'usuario'
            )->findOrFail($id);

        return view('reportes.detalle', compact('reporte'));
    }

    public function destoy($id){
                $user = Auth::guard('Usuario')->user();

        if ($user->USUARIO_ROL != 'ADMINISTRADOR') {
            abort(403, 'Acceso no autorizado');
        }

        $reporte = Reporte::find($id)->first();
        $reporte->delete();

        return redirect()
        ->route('admin.main', ['seccion' => 'reportes'])
        ->with('success', 'Reporte eliminado correctamente');
    }
}
