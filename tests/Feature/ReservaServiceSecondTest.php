<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\ReservaService;
use App\Models\Mesa;
use App\Models\Empleado;
use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReservaServiceSecondTest extends TestCase
{
    use RefreshDatabase;

    protected $reservaService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->reservaService = new ReservaService();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function puede_crear_reserva_correctamente()
    {
        $cliente = Cliente::factory()->create();
        $empleado = Empleado::factory()->create(
            [
                'EMPLEADO_TURNO' => 'M'
            ]
        );

        Mesa::factory()->count(3)->create(['MESA_CAPACIDAD' => 4, 'MESA_STATUS' => 'LIBRE']);

        $fecha = now()->addDay()->format('Y-m-d');
        $hora = '14:00';

        $reserva = $this->reservaService->crearReserva($cliente->USUARIO_ID, $fecha, $hora, 4);

        $this->assertNotNull($reserva);
        $this->assertEquals($cliente->USUARIO_ID, $reserva->CLIENTE_ID);
        $this->assertCount(1, $reserva->mesas);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function lanza_excepcion_si_no_hay_mesas_disponibles()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('No hay mesas disponibles suficientes para ese horario.');

        $cliente = Cliente::factory()->create();
        Empleado::factory()->create();
        // No creamos mesas

        $fecha = now()->addDay()->format('Y-m-d');
        $hora = '14:00';

        $this->reservaService->crearReserva($cliente->USUARIO_ID, $fecha, $hora, 4);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function puede_cancelar_reserva()
    {
        $cliente = Cliente::factory()->create();
        Empleado::factory()->create(
            [
                'EMPLEADO_TURNO' => 'M'
            ]
        );
        $mesa = Mesa::factory()->create(['MESA_CAPACIDAD' => 4, 'MESA_STATUS' => 'LIBRE']);

        $fecha = now()->addDay()->format('Y-m-d');
        $hora = '12:00';

        $reserva = $this->reservaService->crearReserva($cliente->USUARIO_ID, $fecha, $hora, 2);
        $this->reservaService->cancelarReserva($reserva->RESERVA_ID);

        $this->assertDatabaseHas('reserva_mesa', [
            'RESERVA_ID' => $reserva->RESERVA_ID,
            'STATUS' => 'INACTIVO'
        ]);
    }
}
