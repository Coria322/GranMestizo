<?php
/**
 * Este servicio funciona correctamente para el caso general
 * pero carece de especificidad al momento de:
 * !asignar mesas de la misma sección
 * !asignar mesas con la capacidad más cercana posible al numero  de comensales
 * TODO corregir esta lógica para cumplir con lo anterior
 */

/**
 * TODO2
 * ?validar que la fecha no sea menor que hoy y ahora (esto se puede hacer en el controller)
 * ?Evitar reservas fuera del horario de atencion (se debe definir)
 * ?Validar que el cliente no tiene una reserva identica a la que intenta hacer (puede hacerse en el controller)
 * ?agregar cancelaciones de reservas cambiando el status de MesaReserva a inactivo
 */
namespace App\Services;

use App\Models\Reserva;
use App\Models\Mesa;
use App\Models\Empleado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;

class ReservaService
{
    public function crearReserva($clienteId, $fecha, $hora, $comensales)
    {
        return DB::transaction(function () use ($clienteId, $fecha, $hora, $comensales) {
            $inicio = Carbon::parse("$fecha $hora");
            $fin = (clone $inicio)->addHours(2);

            // 1. Buscar mesas disponibles
            $mesasDisponibles = $this->obtenerMesasDisponibles($fecha, $hora);

            // 2. Asignar mesas necesarias
            $mesasAsignadas = $this->seleccionarMesas($mesasDisponibles, $comensales);

            if (empty($mesasAsignadas)) {
                throw new Exception('No hay mesas disponibles suficientes para ese horario.');
            }

            // 3. Buscar mesero disponible
            $empleadoId = $this->buscarEmpleadoDisponible($fecha, $hora);
            if (!$empleadoId) {
                throw new Exception('No hay meseros disponibles para ese horario.');
            }

            // 4. Crear la reserva
            $reserva = Reserva::create([
                'RESERVA_ID' => 'RESE_' . Str::random(5),
                'CLIENTE_ID' => $clienteId,
                'EMPLEADO_ID' => $empleadoId,
                'RESERVA_COMENSALES' => $comensales,
                'RESERVA_FECHA' => $fecha,
                'RESERVA_HORA' => $hora,
            ]);

            // 5. Asociar mesas
            foreach ($mesasAsignadas as $mesa) {
                $reserva->mesas()->attach($mesa->MESA_ID, ['STATUS' => 'ACTIVO']);
            }

            return $reserva->load('mesas', 'cliente', 'empleado');
        });
    }

    private function obtenerMesasDisponibles($fecha, $hora)
    {
        $inicio = Carbon::parse("$fecha $hora");
        $fin = (clone $inicio)->addHours(2);

        return Mesa::where('MESA_STATUS', 'LIBRE')
            ->whereDoesntHave('reservas', function ($query) use ($fecha, $inicio, $fin) {
                $query->where('RESERVA_FECHA', $fecha)
                    ->whereHas('reservasMesas', function ($pivotQuery) {
                        $pivotQuery->where('STATUS', 'ACTIVO'); // ahora sí filtramos la tabla pivote directamente
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

    private function buscarEmpleadoDisponible($fecha, $hora)
    {
        $inicio = Carbon::parse("$fecha $hora");
        $fin = (clone $inicio)->addHours(2);

        $empleadoId = Empleado::whereDoesntHave('reservas', function ($query) use ($fecha, $inicio, $fin) {
            $query->where('RESERVA_FECHA', $fecha)
                ->where(function ($sub) use ($inicio, $fin) {
                    $sub->whereTime('RESERVA_HORA', '<', $fin->format('H:i'))
                        ->whereRaw("ADDTIME(RESERVA_HORA, '02:00:00') > ?", [$inicio->format('H:i')]);
                });
        })->pluck('USUARIO_ID')->first();

        return $empleadoId;
    }

    
}
