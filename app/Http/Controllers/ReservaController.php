<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ReservaService;
use Illuminate\Validation\ValidationException;
use Exception;

class ReservaController extends Controller
{
    protected $reservaService;

    public function __construct(ReservaService $reservaService)
    {
        $this->reservaService = $reservaService;
    }

    /**
     * Crear una nueva reserva
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|string|exists:clientes,USUARIO_ID',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
            'comensales' => 'required|integer|min:1',
        ]);

        try {
            $reserva = $this->reservaService->crearReserva(
                $request->cliente_id,
                $request->fecha,
                $request->hora,
                $request->comensales
            );
            return response()->json(['message' => 'Reserva creada con éxito.', 'reserva' => $reserva], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Listar reservas (opcionalmente filtradas por cliente, fecha o estado)
     */
    public function index(Request $request)
    {
        $filtros = $request->only(['cliente_id', 'fecha', 'estado']);
        try {
            $reservas = $this->reservaService->listarReservas($filtros);
            return response()->json(['reservas' => $reservas], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al listar reservas.'], 500);
        }
    }

    /**
     * Mostrar detalles de una reserva específica
     */
    public function show($id)
    {
        try {
            $reserva = $this->reservaService->obtenerReserva($id);
            return response()->json(['reserva' => $reserva], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Reserva no encontrada.'], 404);
        }
    }

    /**
     * Actualizar una reserva (cambiar fecha, hora o cantidad de comensales)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
            'comensales' => 'required|integer|min:1',
        ]);

        try {
            $reserva = $this->reservaService->actualizarReserva(
                $id,
                $request->fecha,
                $request->hora,
                $request->comensales
            );
            return response()->json(['message' => 'Reserva actualizada con éxito.', 'reserva' => $reserva], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Cancelar una reserva (cambia status a inactivo, libera mesas y mesero)
     */
    public function destroy($id)
    {
        try {
            $this->reservaService->cancelarReserva($id);
            return response()->json(['message' => 'Reserva cancelada con éxito.'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'No se pudo cancelar la reserva.'], 400);
        }
    }
}
