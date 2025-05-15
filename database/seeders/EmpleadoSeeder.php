<?php

namespace Database\Seeders;

use App\Models\Empleado;
use Illuminate\Database\Seeder;

class EmpleadoSeeder extends Seeder
{
    public function run()
    {
        $empleados = Empleado::factory()->count(5)->create();

        $this->command->info("Se crearon {$empleados->count()} empleados:");
        foreach ($empleados as $empleado) {
            $this->command->line("- Usuario ID: {$empleado->USUARIO_ID} | RFC: {$empleado->EMPLEADO_RFC} | Turno: {$empleado->EMPLEADO_TURNO}");
        }
    }
}
