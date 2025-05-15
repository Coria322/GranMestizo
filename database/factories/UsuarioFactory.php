<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{

    protected static ?string $contraseña;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'USUARIO_ID' => substr($this->faker->uuid, 0, 10),
            'USUARIO_NOMBRE' => $this->faker->firstName,
            'USUARIO_APELLIDO' => $this->faker->lastName,
            'USUARIO_CORREO' => $this->faker->unique()->safeEmail,
            'USUARIO_PWD' => 'password',
            'USUARIO_ROL' => 'CLIENTE',
        ];
    }
}
