<?php

namespace Database\Seeders;

use App\Models\Empleado;
use Illuminate\Database\Seeder;

class EmpleadoSeeder extends Seeder
{
    public function run()
    {
        //* Llamada a crear 5 empleados
        $empleados = Empleado::factory()->count(5)->create();

        //* Mostrar por consola datos relevantes de los empleados creados
        $this->command->info("Se crearon {$empleados->count()} empleados:");
        foreach ($empleados as $empleado) {
            $this->command->line("- Usuario ID: {$empleado->USUARIO_ID} | RFC: {$empleado->EMPLEADO_RFC} | Turno: {$empleado->EMPLEADO_TURNO}");
        }
    }
}
