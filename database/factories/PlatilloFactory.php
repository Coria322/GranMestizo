<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PlatilloFactory extends Factory
{
    public function definition(): array
    {
        return [
            'PLATILLO_NOMBRE' => $this->faker->unique()->words(2, true),
            'PLATILLO_DESCRIPCION' => $this->faker->sentence(),
            'PLATILLO_IMAGEN' =>  'platillos/platillo-1.png', // o puedes usar imágenes de prueba si tienes configurado storage
            'PLATILLO_STATUS' => $this->faker->randomElement(['activo', 'inactivo']),
        ];
    }
}
