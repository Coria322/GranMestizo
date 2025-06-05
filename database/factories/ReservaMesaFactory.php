<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Mesa;
use App\Models\Reserva;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReservaMesa>
 */
class ReservaMesaFactory extends Factory
{
    /**
     * Define las relaciones entre la reserva y la mesa.
     * Esta fábrica crea una relación entre una reserva y una mesa, asegurando que la mesa esté libre antes de asignarla.
     * Si no hay mesas libres, se crea una nueva mesa ocupada para la reserva.
     */
    public function definition(): array
    {

        //* Aquí tomamos una mesa libre
        $mesa = Mesa::where('MESA_STATUS', 'LIBRE')->inRandomOrder()->first();

        //* De no existir una se creará una por practicidad del seeder
        if (!$mesa) {
            $mesa = Mesa::factory()->state([
                'MESA_STATUS' => 'OCUPADO'
            ]);
        }
        //* Si la mesa existe cambiamos el estado a ocupada
        else{
            $mesa->update(['MESA_STATUS' => 'OCUPADO']);
        }

        //* Creamos la reserva
        $reserva = Reserva::factory()->create();

        return [
            //* Datos propios de la tabla
            'STATUS' => 'ACTIVO',

            //* Datos creados o recuperados
            'MESA_ID' => $mesa->MESA_ID,
            'RESERVA_ID' => $reserva->RESERVA_ID,
        ];
    }
}
