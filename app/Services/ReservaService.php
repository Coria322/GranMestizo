<?php

/**
 * Este servicio maneja la lógica de negocio relacionada con las reservas de mesas.
 * Permite crear, listar, actualizar y cancelar reservas, así como verificar la disponibilidad de mesas y empleados.
 * También incluye funcionalidades para obtener fechas bloqueadas y validar horarios de atención. 
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
    protected $cierre = '22:00';
    private $duracionReservaHoras = 2;

    /**
     * Crea una nueva reserva de mesa.
     * @param $clienteId ID del cliente que realiza la reserva.
     * @param $fecha Fecha de la reserva en formato 'Y-m-d'.
     * @param $hora Hora de la reserva en formato 'H:i'.
     * @param $comensales Número de comensales para la reserva.
     * Validaciones:
     * - Verifica que haya mesas disponibles para el número de comensales.
     * - Verifica que haya un mesero disponible para el horario solicitado.
     * - La reserva debe realizarse dentro del horario de atención del restaurante.
     * - La reserva debe tener una duración de 2 horas.
     */
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

    /**
     * Obtiene las mesas disponibles para una fecha y hora específicas.
     * @param $fecha Fecha de la reserva en formato 'Y-m-d'.
     * @param $hora Hora de la reserva en formato 'H:i'.
     * Validaciones:
     * - Las mesas deben estar libres.
     * - No deben tener reservas activas que se solapen con el horario de la nueva reserva.
     * - Las reservas deben tener una duración de 2 horas.
     */
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


    /**
     * Selecciona las mesas necesarias para cubrir el número de comensales.
     * @param $mesasDisponibles Colección de mesas disponibles.
     * @param $comensales Número de comensales para la reserva.
     * @return array Lista de mesas seleccionadas o un array vacío si no se pueden cubrir los comensales.
     * Validaciones:
     * - Suma la capacidad de las mesas seleccionadas hasta alcanzar o superar el número de comensales.
     * - Si no se pueden cubrir los comensales, retorna un array vacío.
     */
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

    /**
     * Busca un empleado disponible para una fecha y hora específicas.
     * @param $fecha Fecha de la reserva en formato 'Y-m-d'.
     * @param $hora Hora de la reserva en formato 'H:i'.
     * Validaciones:
     * - El empleado no debe tener reservas activas que se solapen con el horario de la nueva reserva.
     */
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

    /**
     * Lista las reservas según los filtros proporcionados.
     * @param $filtros Filtros opcionales para la búsqueda de reservas.
     * Validaciones:
     * - Si se proporciona un usuario_id, busca reservas donde el cliente o el empleado coincidan.
     * - Si se proporciona una fecha, filtra las reservas por esa fecha.
     * - Ordena las reservas por fecha y hora en orden descendente.
     */
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


    /**
     * Obtiene una reserva específica por su ID.
     * @param $id ID de la reserva a buscar.
     * Validaciones:
     * - Si no se encuentra la reserva, lanza una excepción.
     * - Carga las relaciones de mesas, cliente y empleado.
     */
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

    /**
     * Actualiza una reserva existente.
     * @param $id ID de la reserva a actualizar.
     * @param $nuevaFecha Nueva fecha de la reserva en formato 'Y-m-d'.
     * @param $nuevaHora Nueva hora de la reserva en formato 'H:i'.
     * @param $nuevosComensales Nuevo número de comensales para la reserva.
     * Validaciones:
     * - Crea una nueva reserva con los datos actualizados.
     */
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

    /**
     * Cancela una reserva existente.
     * @param $id ID de la reserva a cancelar.
     * - Inactiva todos los registros en la tabla pivote reserva_mesa para esta reserva.
     * - Si no se encuentra la reserva, lanza una excepción.
     */
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
    /**
     * Obtiene las fechas bloqueadas para reservas.
     * @param $diasAdelante Número de días hacia adelante para verificar fechas bloqueadas.
     * Validaciones:
     * - Revisa cada día hasta $diasAdelante y verifica si hay mesas disponibles en el horario de apertura y cierre.
     * - Si no hay mesas disponibles en todo el horario, se considera la fecha como bloqueada.
     */
    public function obtenerFechasBloqueadas($diasAdelante = 15)
    {
        $fechasBloqueadas = [];
        $hApertura = Carbon::parse($this->apertura);
        $hCierre = Carbon::parse($this->cierre);
        $duracion = $this->duracionReservaHoras;

        for ($i = 0; $i <= $diasAdelante; $i++) {
            $fecha = Carbon::today()->addDays($i)->toDateString();
            $hora = $hApertura->copy();
            $lleno = true;

            while ($hora->lessThan($hCierre)) {
                $mesas = $this->obtenerMesasDisponibles($fecha, $hora->format('H:i'));

                if (count($mesas) > 0) {
                    //hay mesas disponibles en este horario, no es necesario bloquear
                    $lleno = false;
                    break;
                }
                $hora->addHours($duracion);
            }

            if ($lleno) {
                $fechasBloqueadas[] = $fecha;
            }
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
}
