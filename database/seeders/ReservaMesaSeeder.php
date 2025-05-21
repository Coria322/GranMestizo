<?php

namespace Database\Seeders;

use App\Models\ReservaMesa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservaMesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //* Llamar a las fábricas de reservasmesas

        $reservas = ReservaMesa::factory()->count(5)->create();

        $this->command->info("Se crearon {$reservas->count()} reservas:");

        //* Mostrar información importante en la terminal
        foreach ($reservas as $reservaMesa) {
            $this->command->line("- Reserva id: {$reservaMesa->RESERVA_ID} |- Mesa id: {$reservaMesa->MESA_ID} |- Status: {$reservaMesa->STATUS}");
        }
    }
}
