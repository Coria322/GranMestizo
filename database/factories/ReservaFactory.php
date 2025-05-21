<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cliente;
use App\Models\Empleado;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reserva>
 */
class ReservaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //*Datos propios de la reserva
            'RESERVA_ID'  => strtoupper($this->faker->bothify('RESE_??###')),
            'RESERVA_COMENSALES' => $this->faker->numberBetween(1,10),
            'RESERVA_FECHA'=> $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'RESERVA_HORA' => $this->faker->time('H:i'),

            //* Llamados a fabricas de relaciones
            'CLIENTE_ID' => Cliente::factory(),
            'EMPLEADO_ID' => Empleado::factory(),
        ];
    }
}
