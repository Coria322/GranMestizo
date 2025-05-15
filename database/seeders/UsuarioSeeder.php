<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $admins = Usuario::factory()->count(5)->create([
            'USUARIO_ROL' => 'ADMINISTRADOR'
        ]);
        $empleados = Usuario::factory()->count(5)->create([
            'USUARIO_ROL' => 'EMPLEADO'
        ]);
        $clientes = Usuario::factory()->count(5)->create([
            'USUARIO_ROL' => 'CLIENTE'
        ]);

        $this->command->info("Usuarios creados: ");
        $this->command->line("- Admins: {$admins->count()}");
        $this->command->line("- Empleados: {$empleados->count()}");
        $this->command->line("- Clientes: {$clientes->count()}");
    }
}
