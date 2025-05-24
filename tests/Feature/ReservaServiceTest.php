<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Cliente;
use App\Models\Mesa;
use App\Models\Empleado;
use App\Services\ReservaService;
use Carbon\Carbon;

class ReservaServiceTest extends TestCase
{

    use RefreshDatabase;
    
    #[\PHPUnit\Framework\Attributes\Test]
    public function puede_crear_una_reserva_con_mesas_y_mesero_disponibles()
    {
        // Crear cliente y empleado
        $cliente = Cliente::factory()->create();
        $empleado = Empleado::factory()->create();

        // Crear mesas disponibles
        Mesa::factory()->count(3)->create([
            'MESA_CAPACIDAD' => 4,
            'MESA_STATUS' => 'LIBRE',
        ]);

        $service = new ReservaService();
        $fecha = Carbon::today()->toDateString();
        $hora = '18:00';

        $reserva = $service->crearReserva($cliente->USUARIO_ID, $fecha, $hora, 5);

        $this->assertDatabaseHas('reservas', [
            'CLIENTE_ID' => $cliente->USUARIO_ID,
            'EMPLEADO_ID' => $empleado->USUARIO_ID,
            'RESERVA_FECHA' => $fecha,
            'RESERVA_HORA' => $hora,
        ]);

        $this->assertTrue($reserva->mesas->sum('MESA_CAPACIDAD') >= 5);
    }


    #[\PHPUnit\Framework\Attributes\Test]
    public function no_puede_crear_reserva_si_no_hay_mesas_suficientes()
    {
        $cliente = Cliente::factory()->create();
        Empleado::factory()->create();

        // Solo hay una mesa de 2, y se necesitan 6 lugares
        Mesa::factory()->create([
            'MESA_CAPACIDAD' => 2,
            'MESA_STATUS' => 'LIBRE',
        ]);

        $service = new ReservaService();
        $fecha = now()->toDateString();
        $hora = '19:00';

        $this->expectExceptionMessage('No hay mesas disponibles suficientes para ese horario.');
        $service->crearReserva($cliente->USUARIO_ID, $fecha, $hora, 6);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function no_puede_crear_reserva_si_no_hay_meseros_disponibles()
    {
        $cliente = Cliente::factory()->create();
        // No se crea ningún empleado

        Mesa::factory()->count(2)->create([
            'MESA_CAPACIDAD' => 4,
            'MESA_STATUS' => 'LIBRE',
        ]);

        $fecha = now()->toDateString();
        $hora = '20:00';

        $this->expectExceptionMessage('No hay meseros disponibles para ese horario.');

        $service = new ReservaService();
        $service->crearReserva($cliente->USUARIO_ID, $fecha, $hora, 4);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function no_puede_usar_mesa_ya_ocupada_en_mismo_horario()
    {
        $cliente = Cliente::factory()->create();
        $empleado = Empleado::factory()->create();
        $mesa = Mesa::factory()->create([
            'MESA_CAPACIDAD' => 4,
            'MESA_STATUS' => 'LIBRE',
        ]);

        $fecha = now()->toDateString();
        $hora = '21:00';

        // Primera reserva exitosa
        $service = new ReservaService();
        $service->crearReserva($cliente->USUARIO_ID, $fecha, $hora, 3);

        // Segunda reserva intenta usar la misma mesa en el mismo horario
        $otroCliente = Cliente::factory()->create();
        $this->expectExceptionMessage('No hay mesas disponibles suficientes para ese horario.');

        $service->crearReserva($otroCliente->USUARIO_ID, $fecha, $hora, 2);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function no_puede_reservar_si_todas_las_mesas_ya_estan_reservadas_en_el_horario()
    {
        $cliente = Cliente::factory()->create();
        $empleado = Empleado::factory()->create();

        $mesa = Mesa::factory()->create([
            'MESA_CAPACIDAD' => 4,
            'MESA_STATUS' => 'LIBRE',
        ]);

        $fecha = now()->toDateString();
        $hora = '17:00';

        $service = new ReservaService();
        $service->crearReserva($cliente->USUARIO_ID, $fecha, $hora, 3);

        // Mismo cliente intenta otra reserva en el mismo horario, sin más mesas
        $this->expectExceptionMessage('No hay mesas disponibles suficientes para ese horario.');

        $service->crearReserva($cliente->USUARIO_ID, $fecha, $hora, 2);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function puede_reservar_la_misma_mesa_en_horarios_diferentes()
    {
        $cliente = Cliente::factory()->create();
        $empleado = Empleado::factory()->create();

        $mesa = Mesa::factory()->create([
            'MESA_CAPACIDAD' => 4,
            'MESA_STATUS' => 'LIBRE',
        ]);

        $service = new ReservaService();

        $fecha = now()->toDateString();

        // Reserva 1 a las 15:00
        $reserva1 = $service->crearReserva($cliente->USUARIO_ID, $fecha, '15:00', 3);
        $this->assertDatabaseHas('reservas', [
            'RESERVA_ID' => $reserva1->RESERVA_ID,
            'RESERVA_FECHA' => $fecha,
            'RESERVA_HORA' => '15:00',
        ]);

        // Reserva 2 a las 18:00 (no se solapan con la de las 15:00)
        $reserva2 = $service->crearReserva($cliente->USUARIO_ID, $fecha, '18:00', 3);
        $this->assertDatabaseHas('reservas', [
            'RESERVA_ID' => $reserva2->RESERVA_ID,
            'RESERVA_FECHA' => $fecha,
            'RESERVA_HORA' => '18:00',
        ]);
    }
}
