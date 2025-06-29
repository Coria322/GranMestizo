<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Admin;
use App\Models\Usuario;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    protected $model = Admin::class;

    /**
     * Define a un Administrador con un usuario que tenga el rol de 'ADMINISTRADOR'.
     */
    public function definition()
    {
        return [
            'USUARIO_ID' => Usuario::factory()->state([
                'USUARIO_ROL' => 'ADMINISTRADOR'
            ])
        ];
    }
}
