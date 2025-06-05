<?php

namespace App\Http\Controllers;

use App\Models\Platillo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlatilloController extends Controller
{
    public function create()
    {
        return view('platillos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'PLATILLO_NOMBRE' => 'required|string|max:100',
            'PLATILLO_DESCRIPCION' => 'nullable|string',
            'PLATILLO_IMAGEN' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['PLATILLO_NOMBRE', 'PLATILLO_DESCRIPCION']);

        if ($request->hasFile('PLATILLO_IMAGEN')) {
            $data['PLATILLO_IMAGEN'] = $request->file('PLATILLO_IMAGEN')->store('platillos', 'public');
        }

        Platillo::create($data);

        return redirect()->route('admin.main', ['seccion' => 'menu'])->with('success', 'Platillo creado correctamente.');
    }

    public function show(Platillo $id)
    {
        $platillo = Platillo::find($id)->first();
        return view('platillos.show', compact('platillo'));
    }

    public function edit($id)
    {
        $platillo = Platillo::find($id)->first();
        return view('platillos.edit', compact('platillo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'PLATILLO_NOMBRE' => 'required|string|max:100',
            'PLATILLO_DESCRIPCION' => 'nullable|string',
            'PLATILLO_IMAGEN' => 'nullable|image|max:2048',
            'PLATILLO_STATUS' => 'required|in:activo,inactivo', // validación agregada
        ]);

        $data = $request->only(['PLATILLO_NOMBRE', 'PLATILLO_DESCRIPCION', 'PLATILLO_STATUS']);

        if ($request->hasFile('PLATILLO_IMAGEN')) {
            $data['PLATILLO_IMAGEN'] = $request->file('PLATILLO_IMAGEN')->store('platillos', 'public');
        }

        Platillo::find($id)->update($data);

        return redirect()
            ->route('admin.main', ['seccion' => 'menu'])
            ->with('success', 'Platillo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $user = Auth::guard('Usuario')->user();

        if ($user->USUARIO_ROL != 'ADMINISTRADOR') {
            abort(403, 'Acceso no autorizado');
        }

        $platillo = Platillo::findOrFail($id);


        $platillo->delete();

        return redirect()->route('admin.main', ['seccion' => 'menu'])
            ->with('success', 'Platillo eliminado correctamente.');
    }

    /**
     * Cambiar el estado del platillo según el actual
     */
    public function cambiarEstado($id)
    {
        $user = Auth::guard('Usuario')->user();

        if ($user->USUARIO_ROL != 'ADMINISTRADOR') {
            abort(403, 'No tienes permiso para cambiar el estado de este platillo');
        }

        $platillo = Platillo::findOrFail($id);

        $estado = $platillo->PLATILLO_STATUS === 'activo' ? 'inactivo' : 'activo';


        $platillo->update(['PLATILLO_STATUS'=> $estado]);

        return redirect()
        ->route('admin.main', ['seccion'=> 'menu'])
        ->with('success', 'platillo actualizado exitosamente');
    }
}
