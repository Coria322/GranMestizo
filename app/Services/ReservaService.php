<?php
/**
 * Este servicio funciona correctamente para el caso general
 * pero carece de especificidad al momento de:
 * !asignar mesas de la misma sección
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
use App\Models\ReservaMesa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;

class ReservaService
{
    protected $apertura = '12:00';
    protected $cierre = '22:00' ;
    private $duracionReservaHoras = 2;

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
                'RESERVA_ID' => 'RESE_' . strtoupper(Str::random(5)),
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

    public function obtenerMesasDisponibles($fecha, $hora)
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

    public function buscarEmpleadoDisponible($fecha, $hora)
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

            // Cancelamos la reserva actual para liberar mesas y mesero
            $this->cancelarReserva($id);

            // Creamos una nueva reserva con los datos actualizados
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

        // Inactivar todos los registros en reserva_mesa para esta reserva
        ReservaMesa::where('RESERVA_ID', $id)->update(['STATUS' => 'INACTIVO']);

        return true;
    });
}

//Las reservas pueden ser con 15 dias de antelación
//todo, esto y los horarios pueden ser alterables mediante una tabla en bd
//?esto se deja a consideración de las reglas del negocio
    public function obtenerFechasBloqueadas($diasAdelante = 15){
        $fechasBloqueadas = [];
        $hApertura = Carbon::parse($this->apertura);
        $hCierre = Carbon::parse($this->cierre);
        $duracion = $this->duracionReservaHoras;

        for ($i=0; $i <= $diasAdelante ; $i++) { 
            $fecha = Carbon::today()->addDays($i)->toDateString();
            $hora = $hApertura->copy();
            $lleno = true;

            while($hora->lessThan($hCierre)){
                $mesas = $this->obtenerMesasDisponibles($fecha, $hora->format('H:i'));

                if (count($mesas) > 0) {
                    //hay mesas disponibles en este horario, no es necesario bloquear
                    $lleno = false;
                    break;
                }
                $hora -> addHours($duracion);
            }

            if ($lleno) {
                $fechasBloqueadas[] = $fecha; 
            }
        }
        return $fechasBloqueadas;
    }

    public function getApertura(){
        return $this->apertura;
    }

    public function getCierre(){
        return $this->cierre;
    }

    public function getDuracion(){
        return $this->duracionReservaHoras;
    }
}
