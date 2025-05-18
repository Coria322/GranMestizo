<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mesa;

class MesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //* Llamado a las fabricas de mesa
        $mesas = Mesa::factory()->count(20)->create();

        //* Mostrar información relevante en la consola
        $this->command->info("Se crearon {$mesas->count()} mesas:");

        foreach ($mesas as $mesa) {
            $this->command->line( "- Mesa ID: {$mesa->MESA_ID} |- Capacidad: {$mesa->MESA_CAPACIDAD} |- Sección: {$mesa->MESA_SECCION} |- Status: {$mesa->MESA_STATUS}");
        }
    }
}
