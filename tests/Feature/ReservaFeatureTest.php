<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Mesa;
use App\Models\Usuario;

class ReservaFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function puede_crear_reserva_exitosa_via_http()
    {
        // Crear cliente y empleado
        $usuarioCliente = Usuario::factory()->create();
        $cliente = Cliente::factory()->create(['USUARIO_ID' => $usuarioCliente->USUARIO_ID]);

        $usuarioEmpleado = Usuario::factory()->create();
        $empleado = Empleado::factory()->create(['USUARIO_ID' => $usuarioEmpleado->USUARIO_ID]);

        // Crear mesas suficientes
        Mesa::factory()->count(3)->create([
            'MESA_CAPACIDAD' => 2,
            'MESA_STATUS' => 'LIBRE'
        ]);

        // Ejecutar la petición HTTP simulada
        $response = $this->postJson('/api/reservas', [
            'cliente_id' => $cliente->USUARIO_ID,
            'fecha' => now()->addDay()->toDateString(),
            'hora' => '18:00',
            'comensales' => 4
        ]);

        // Validar respuesta
        $response->assertStatus(201);
        $response->assertJson([
            'message' => 'Reserva creada con éxito.',
        ]);

        $this->assertDatabaseHas('reservas', [
            'CLIENTE_ID' => $cliente->USUARIO_ID,
            'RESERVA_COMENSALES' => 4,
        ]);
    }

    /** @test */
    public function lanza_error_si_no_hay_mesas_disponibles()
    {
        $usuarioCliente = Usuario::factory()->create();
        $cliente = Cliente::factory()->create(['USUARIO_ID' => $usuarioCliente->USUARIO_ID]);

        $usuarioEmpleado = Usuario::factory()->create();
        Empleado::factory()->create(['USUARIO_ID' => $usuarioEmpleado->USUARIO_ID]);

        // No hay mesas creadas

        $response = $this->postJson('/api/reservas', [
            'cliente_id' => $cliente->USUARIO_ID,
            'fecha' => now()->addDay()->toDateString(),
            'hora' => '20:00',
            'comensales' => 2
        ]);

        $response->assertStatus(400);
        $response->assertJsonStructure(['error']);
    }
}
