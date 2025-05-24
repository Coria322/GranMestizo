<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mesa;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Reserva;
use App\Models\ReservaMesa;
use Carbon\Carbon;

class ReservaDemoSeeder extends Seeder
{
    public function run(): void
    {
        // Crear mesas suficientes (10 mesas con distintas capacidades)
        $mesas = Mesa::factory()->count(10)->create();

        // Crear cliente y empleado
        $cliente = Cliente::factory()->create();
        $empleado = Empleado::factory()->create();

        // Definir fechas de prueba
        $fechaCompleta = '2025-06-01';
        $fechaParcial = '2025-06-02';

        // Horarios permitidos de 12:00 a 20:00 en bloques de 2 horas
        $horarios = ['12:00:00', '14:00:00', '16:00:00', '18:00:00', '20:00:00'];

        // Día completamente bloqueado
        foreach ($horarios as $hora) {
            foreach ($mesas as $mesa) {
                $reserva = Reserva::create([
                    'RESERVA_ID' => strtoupper(fake()->bothify('RESE_??###')),
                    'RESERVA_COMENSALES' => rand(1, $mesa->MESA_CAPACIDAD),
                    'RESERVA_FECHA' => $fechaCompleta,
                    'RESERVA_HORA' => $hora,
                    'CLIENTE_ID' => $cliente->USUARIO_ID,
                    'EMPLEADO_ID' => $empleado->USUARIO_ID,
                ]);

                ReservaMesa::create([
                    'MESA_ID' => $mesa->MESA_ID,
                    'RESERVA_ID' => $reserva->RESERVA_ID,
                    'STATUS' => 'ACTIVO',
                ]);
            }
        }

        // Día parcialmente bloqueado: solo 14:00 y 18:00
        foreach (['14:00:00', '18:00:00'] as $hora) {
            foreach ($mesas as $mesa) {
                $reserva = Reserva::create([
                    'RESERVA_ID' => strtoupper(fake()->bothify('RESE_??###')),
                    'RESERVA_COMENSALES' => rand(1, $mesa->MESA_CAPACIDAD),
                    'RESERVA_FECHA' => $fechaParcial,
                    'RESERVA_HORA' => $hora,
                    'CLIENTE_ID' => $cliente->USUARIO_ID,
                    'EMPLEADO_ID' => $empleado->USUARIO_ID,
                ]);

                ReservaMesa::create([
                    'MESA_ID' => $mesa->MESA_ID,
                    'RESERVA_ID' => $reserva->RESERVA_ID,
                    'STATUS' => 'ACTIVO',
                ]);
            }
        }
    }
}
