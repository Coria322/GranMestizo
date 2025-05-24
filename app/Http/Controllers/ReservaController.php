<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ReservaService;
use App\Models\Reserva;
use Carbon\Carbon;
use Exception;

class ReservaController extends Controller
{
    protected $reservaService;
    protected $horaApertura;

    protected $horaCierre;

    protected $duracion;

    public function __construct(ReservaService $reservaService)
    {
        // $this->middleware('auth:Usuario');
        $this->reservaService = $reservaService;

        //Tomamos constantes del servicio. En una necesidad real podrían ser constantes almacenadas en config o bd
        $this->horaApertura = $this->reservaService->getApertura();
        $this->horaCierre = $this->reservaService->getCierre();
        $this->duracion = $this->reservaService->getDuracion();
    }

    public function create()
    {
        return view('reservas.crear');
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

    public function obtenerHorasOcupadas(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
        ]);

        $fecha = $request->input('fecha');

        // Obtenemos todas las reservas con mesas activas para la fecha dada
        $reservas = Reserva::where('RESERVA_FECHA', $fecha)
            ->whereHas('mesas', function ($query) {
                $query->where('reserva_mesa.STATUS', 'ACTIVO');
            })
            ->get();

        // Extraemos las horas ocupadas para devolverlas
        $horasOcupadas = $reservas->pluck('RESERVA_HORA')->map(function ($hora) {
            return substr($hora, 0, 5); // Formato 'HH:MM'
        })->unique()->values()->all();

        return response()->json(['horasReservadas' => $horasOcupadas]);
    }

    public function obtenerHorasDisponibles(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
        ]);

        $fecha = $request->input('fecha');
        $horaApertura = Carbon::parse($this->horaApertura);
        $horaCierre = Carbon::parse($this->horaCierre);
        $duracion = $this->duracion;

        $horasDisponibles = [];
        $hora = $horaApertura->copy();

        while ($hora->lessThan($horaCierre)) {
            $mesas = $this->reservaService->obtenerMesasDisponibles($fecha, $hora->format('H:i'));

            if (count($mesas) > 0) {
                $horasDisponibles[] = $hora->format('H:i');
            }

            $hora->addHours($duracion);
        }
        return response()->json(['horasDisponibles' => $horasDisponibles],200);
    }

    public function obtenerFechasBloqueadas()
    {
        try {
            $fechas = $this->reservaService->obtenerFechasBloqueadas();
            
            return response()->json(['fechasBloqueadas' => $fechas], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al obtener fechas bloqueadas', 500]);
        }
    }
}
