<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mesa>
 */
class MesaFactory extends Factory
{
    /**
     * Define una Mesa con atributos predefinidos.
     */
    public function definition(): array
    {
        return [
            'MESA_ID' => strtoupper($this->faker->bothify('MESA_??###')),
            'MESA_CAPACIDAD' => $this->faker->randomElement([1,2,4,6,8,10]),
            'MESA_STATUS' => 'LIBRE',
            'MESA_SECCION' => $this->faker->randomElement(['A1','B1','C1','A2','B2', 'C2']),
        ];
    }
}
