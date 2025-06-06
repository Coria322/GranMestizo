<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mesa;
use Illuminate\Support\Str;


class mesaController extends Controller
{
    public function create()
    {
        // Lógica para mostrar el formulario de creación de mesa
        return view('mesas.create');
    }

    public function store(Request $request){
        try {
            $validated = $request->validate([
                'Capacidad' => 'required|integer|min:1',
                'Status' => 'required|in:LIBRE,OCUPADO',
                'Seccion' => 'required|string|max:255',
            ]);

            Mesa::create([
                'MESA_ID' => 'MESA_' . substr(Str::uuid()->toString(), 0, 5),
                'MESA_CAPACIDAD' => $validated['Capacidad'],
                'MESA_STATUS' => $validated['Status'],
                'MESA_SECCION' => $validated['Seccion'],
            ]);

            return redirect()->route('admin.main', ['seccion' => 'mesas'])->with('success','Mesa creada correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocurrió un error al crear la mesa: ' . $e->getMessage()]);
        }
    }

    public function show($id){
        $mesa =Mesa::with([
            'reservas',
            'reservasMesas'
            ])->findOrFail($id);

        return view('mesas.detalle', compact('mesa'));
    }

    public function destroy($id)
    {
        try {
            $mesa = Mesa::findOrFail($id);
            if ($mesa->reservasMesas()->where('status', 'ACTIVO')->exists()) {
                return redirect()->route('admin.main', ['seccion' => 'mesas'])->with('error', 'No se puede eliminar la mesa porque tiene reservas activas asociadas.');
            }
            $mesa->delete();
            return redirect()->route('admin.main', ['seccion' => 'mesas'])->with('success', 'Mesa eliminada correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar la mesa: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $mesa = Mesa::findOrFail($id);
        return view('mesas.edit', compact('mesa'));
    }

    public function update(Request $request, $id){
        try {
            $validated = $request->validate([
                'Capacidad' => 'required|integer|min:1',
                'Status' => 'required|in:LIBRE,OCUPADO',
                'Seccion' => 'required|string|max:255',
            ]);

            $mesa = Mesa::findOrFail($id);
            $mesa->update([
                'MESA_CAPACIDAD' => $validated['Capacidad'],
                'MESA_STATUS' => $validated['Status'],
                'MESA_SECCION' => $validated['Seccion'],
            ]);

            return redirect()->route('admin.main', ['seccion' => 'mesas'])->with('success', 'Mesa actualizada correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Ocurrió un error al actualizar la mesa: ' . $e->getMessage());
        }
    }
}
