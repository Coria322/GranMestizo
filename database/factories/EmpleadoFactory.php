<?php

namespace Database\Factories;

use App\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuario;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empleado>
 */
class EmpleadoFactory extends Factory
{
    protected $model = Empleado::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'EMPLEADO_RFC' => $this->faker->bothify('???###???###'),
            'EMPLEADO_TURNO' => $this->faker->randomElement(['M','V']),
            'EMPLEADO_STATUS' => $this->faker->randomElement(['LIBRE', 'OCUPADO']),
            'USUARIO_ID' => Usuario::factory()->state([
                'USUARIO_ROL' => 'CLIENTE'
            ])
        ];
    }
}
