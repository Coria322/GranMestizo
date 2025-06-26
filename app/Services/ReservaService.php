<?php

namespace App\Services;

use App\Models\Reserva;
use App\Models\Mesa;
use App\Models\Empleado;
use App\Models\ReservaMesa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;

class ReservaService
{
    protected $apertura = '12:00';
    protected $cierre = '22:00';
    private $duracionReservaHoras = 2;

    private $turnos = [
        'M' => ['inicio' => '12:00', 'fin' => '17:00'],
        'V' => ['inicio' => '17:00', 'fin' => '22:00'],
    ];

    public function crearReserva($clienteId, $fecha, $hora, $comensales)
    {
        return DB::transaction(function () use ($clienteId, $fecha, $hora, $comensales) {
            $this->determinarTurno($hora); // Validamos turno válido

            $inicio = Carbon::parse("$fecha $hora");
            $fin = (clone $inicio)->addHours(2);

            $mesasDisponibles = $this->obtenerMesasDisponibles($fecha, $hora);
            $mesasAsignadas = $this->seleccionarMesas($mesasDisponibles, $comensales);

            if (empty($mesasAsignadas)) {
                throw new Exception('No hay mesas disponibles suficientes para ese horario.');
            }

            $empleadoId = $this->buscarEmpleadoDisponible($fecha, $hora);
            if (!$empleadoId) {
                throw new Exception('No hay meseros disponibles para ese horario.');
            }

            $reserva = Reserva::create([
                'RESERVA_ID' => 'RESE_' . strtoupper(Str::random(5)),
                'CLIENTE_ID' => $clienteId,
                'EMPLEADO_ID' => $empleadoId,
                'RESERVA_COMENSALES' => $comensales,
                'RESERVA_FECHA' => $fecha,
                'RESERVA_HORA' => $hora,
            ]);

            foreach ($mesasAsignadas as $mesa) {
                $reserva->mesas()->attach($mesa->MESA_ID, ['STATUS' => 'ACTIVO']);
            }

            return $reserva->load('mesas', 'cliente', 'empleado');
        });
    }

    public function obtenerMesasDisponibles($fecha, $hora)
    {
        $inicio = Carbon::parse("$fecha $hora");
        $fin = (clone $inicio)->addHours(2);

        return Mesa::where('MESA_STATUS', 'LIBRE')
            ->whereDoesntHave('reservas', function ($query) use ($fecha, $inicio, $fin) {
                $query->where('RESERVA_FECHA', $fecha)
                    ->whereHas('reservasMesas', function ($pivotQuery) {
                        $pivotQuery->where('STATUS', 'ACTIVO');
                    })
                    ->where(function ($sub) use ($inicio, $fin) {
                        $sub->whereTime('RESERVA_HORA', '<', $fin->format('H:i'))
                            ->whereRaw("ADDTIME(RESERVA_HORA, '02:00:00') > ?", [$inicio->format('H:i')]);
                    });
            })
            ->orderBy('MESA_CAPACIDAD', 'asc')
            ->get();
    }

    private function seleccionarMesas($mesasDisponibles, $comensales)
    {
        $seleccionadas = [];
        $total = 0;

        foreach ($mesasDisponibles as $mesa) {
            $seleccionadas[] = $mesa;
            $total += $mesa->MESA_CAPACIDAD;
            if ($total >= $comensales) break;
        }

        return $total >= $comensales ? $seleccionadas : [];
    }

    public function buscarEmpleadoDisponible($fecha, $hora)
    {
        $inicio = Carbon::parse("$fecha $hora");
        $fin = (clone $inicio)->addHours(2);

        $turno = $this->determinarTurno($hora);

        return Empleado::where('EMPLEADO_TURNO', $turno)
            ->whereDoesntHave('reservas', function ($query) use ($fecha, $inicio, $fin) {
                $query->where('RESERVA_FECHA', $fecha)
                      ->where(function ($sub) use ($inicio, $fin) {
                          $sub->whereTime('RESERVA_HORA', '<', $fin->format('H:i'))
                              ->whereRaw("ADDTIME(RESERVA_HORA, '02:00:00') > ?", [$inicio->format('H:i')]);
                      });
            })->pluck('USUARIO_ID')->first();
    }

    public function listarReservas(array $filtros = [])
    {
        $query = Reserva::with(['mesas', 'cliente', 'empleado']);

        if (!empty($filtros['usuario_id'])) {
            $usuarioId = $filtros['usuario_id'];

            $query->where(function ($q) use ($usuarioId) {
                $q->where('CLIENTE_ID', $usuarioId)
                    ->orWhere('EMPLEADO_ID', $usuarioId);
            });
        }

        if (!empty($filtros['fecha'])) {
            $query->where('RESERVA_FECHA', $filtros['fecha']);
        }

        return $query->orderBy('RESERVA_FECHA', 'desc')
            ->orderBy('RESERVA_HORA', 'desc')
            ->get();
    }

    public function obtenerReserva($id)
    {
        $reserva = Reserva::with(['mesas', 'cliente', 'empleado'])
            ->where('RESERVA_ID', $id)
            ->first();

        if (!$reserva) {
            throw new Exception("Reserva no encontrada.");
        }

        return $reserva;
    }

    public function actualizarReserva($id, $nuevaFecha, $nuevaHora, $nuevosComensales)
    {
        return DB::transaction(function () use ($id, $nuevaFecha, $nuevaHora, $nuevosComensales) {
            $reserva = Reserva::where('RESERVA_ID', $id)->first();

            if (!$reserva) {
                throw new Exception("Reserva no encontrada.");
            }

            $this->cancelarReserva($id);

            return $this->crearReserva(
                $reserva->CLIENTE_ID,
                $nuevaFecha,
                $nuevaHora,
                $nuevosComensales
            );
        });
    }

    public function cancelarReserva($id)
    {
        return DB::transaction(function () use ($id) {
            $reserva = Reserva::find($id);

            if (!$reserva) {
                throw new Exception("Reserva no encontrada.");
            }

            ReservaMesa::where('RESERVA_ID', $id)->update(['STATUS' => 'INACTIVO']);

            return true;
        });
    }

    public function obtenerFechasBloqueadas($diasAdelante = 15)
    {
        $fechasBloqueadas = [];
        $duracion = $this->duracionReservaHoras;

        for ($i = 0; $i <= $diasAdelante; $i++) {
            $fecha = Carbon::today()->addDays($i)->toDateString();
            $lleno = true;

            foreach ($this->turnos as $rango) {
                $hora = Carbon::parse($rango['inicio']);
                $fin = Carbon::parse($rango['fin']);

                while ($hora->addHours($duracion)->lessThanOrEqualTo($fin)) {
                    $mesas = $this->obtenerMesasDisponibles($fecha, $hora->subHours($duracion)->format('H:i'));
                    if (count($mesas) > 0) {
                        $lleno = false;
                        break 2;
                    }
                }
            }

            if ($lleno) $fechasBloqueadas[] = $fecha;
        }

        return $fechasBloqueadas;
    }

    public function getApertura()
    {
        return $this->apertura;
    }

    public function getCierre()
    {
        return $this->cierre;
    }

    public function getDuracion()
    {
        return $this->duracionReservaHoras;
    }

    public function getTurnos()
    {
        return $this->turnos;
    }

    /**
     * Determina a qué turno pertenece una hora dada.
     * @param string $hora Hora en formato 'H:i'
     * @return string Turno 'M' o 'V'
     * @throws Exception si la hora no pertenece a ningún turno válido
     */
    private function determinarTurno($hora)
    {
        $horaCarbon = Carbon::parse($hora);

        foreach ($this->turnos as $turno => $rango) {
            $inicio = Carbon::parse($rango['inicio']);
            $fin = Carbon::parse($rango['fin'])->subHours($this->duracionReservaHoras);

            if ($horaCarbon->between($inicio, $fin->addHours(2))) {
                return $turno;
            }
        }

        throw new Exception("La hora '$hora' no pertenece a ningún turno válido.");
    }
}
