<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cliente;
use App\Models\Usuario;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Cliente::class;

    public function definition()
    {
        return [
            'USUARIO_ID' => Usuario::factory()->state([
                'USUARIO_ROL' => 'CLIENTE'
            ]),
            'CLIENTE_RFC' => $this->faker->bothify('???###???###'),
        ];
    }
}
