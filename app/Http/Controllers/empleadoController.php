<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Reserva;
use Illuminate\Http\Request;
use App\Models\Mesa;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
        $usuarioGlobal = auth()->guard('Usuario')->user();

        // Obtener datos del empleado
        $empleado = Empleado::where('USUARIO_ID', $usuarioGlobal->USUARIO_ID)->first();

        // Obtener reservas paginadas
        $reservas = Reserva::with(['cliente', 'reservasMesas'])
            ->orderBy('RESERVA_FECHA', 'desc')
            ->orderBy('RESERVA_HORA', 'desc')
            ->paginate(5);

        return view('Empleado.panelP', compact(
            'seccionActiva',
            'usuarioGlobal',
            'empleado',
            'reservas'
        ));
    }

    public function editarPerfil()
    {
        $usuarioGlobal = auth()->guard('Usuario')->user();

        // Cargar la relación con empleado
        $usuarioGlobal->load('empleado');

        return view('Empleado.editEmpleado', compact('usuarioGlobal'));
    }


    public function actualizarPerfil(Request $request)
    {
        $usuarioGlobal = auth()->guard('Usuario')->user();

        $validated = $request->validate([
            'USUARIO_NOMBRE' => 'required|string|max:255',
            'USUARIO_APELLIDO' => 'required|string|max:255',
            'USUARIO_CORREO' => [
                'required',
                'email',
                Rule::unique('usuarios', 'USUARIO_CORREO')->ignore($usuarioGlobal->USUARIO_ID, 'USUARIO_ID')
            ],
            'EMPLEADO_RFC' => [
                'nullable',
                'string',
                'size:13',
                'regex:/^[A-Z]{4}[0-9]{6}[A-Z0-9]{3}$/',
                Rule::unique('empleados', 'EMPLEADO_RFC')->ignore($usuarioGlobal->USUARIO_ID, 'USUARIO_ID')
            ],
            'EMPLEADO_TURNO' => 'nullable|string|in:M,V',
        ], [
            'USUARIO_NOMBRE.required' => 'El nombre es obligatorio.',
            'USUARIO_APELLIDO.required' => 'El apellido es obligatorio.',
            'USUARIO_CORREO.required' => 'El correo electrónico es obligatorio.',
            'USUARIO_CORREO.email' => 'El correo electrónico debe ser válido.',
            'USUARIO_CORREO.unique' => 'Este correo ya está registrado.',
            'EMPLEADO_RFC.size' => 'El RFC debe tener exactamente 13 caracteres.',
            'EMPLEADO_RFC.regex' => 'El formato del RFC no es válido.',
            'EMPLEADO_RFC.unique' => 'Este RFC ya está registrado por otro empleado.',
            'EMPLEADO_TURNO.in' => 'El turno seleccionado no es válido.',
        ]);

        DB::beginTransaction();

        try {
            // Actualizar datos del usuario
            $usuarioGlobal->update([
                'USUARIO_NOMBRE' => $validated['USUARIO_NOMBRE'],
                'USUARIO_APELLIDO' => $validated['USUARIO_APELLIDO'],
                'USUARIO_CORREO' => $validated['USUARIO_CORREO'],
            ]);

            // Actualizar datos del empleado
            $empleado = Empleado::where('USUARIO_ID', $usuarioGlobal->USUARIO_ID)->first();

            if ($empleado) {
                $datosEmpleado = [];

                if (isset($validated['EMPLEADO_RFC'])) {
                    $datosEmpleado['EMPLEADO_RFC'] = $validated['EMPLEADO_RFC'];
                }

                if (isset($validated['EMPLEADO_TURNO'])) {
                    $datosEmpleado['EMPLEADO_TURNO'] = $validated['EMPLEADO_TURNO'];
                }

                if (!empty($datosEmpleado)) {
                    $empleado->update($datosEmpleado);
                }
            }

            DB::commit();

            return redirect()->route('Empleado.panelP', ['seccion' => 'datos'])
                ->with('success', 'Perfil actualizado correctamente.');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->withErrors(['error' => 'Error al actualizar el perfil. Por favor, inténtelo de nuevo. ' . $e->getMessage()])
                ->withInput();
        }
    }
}
