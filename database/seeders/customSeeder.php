<?php

namespace Database\Seeders;

use App\Models\Mesa;
use App\Models\Platillo;
use App\Models\Reserva_Mesa;
use Illuminate\Database\Seeder;
use App\Models\Usuario;

class customSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Ejecutar los seeders
        $data = $this->call([
            AdminSeeder::class,
            ClienteSeeder::class,
            EmpleadoSeeder::class,
            MesaSeeder::class,
            ReservaMesaSeeder::class,
            PlatilloSeeder::class,
        ]);

        $this->command->info('Todos los datos iniciales fueron sembrados correctamente.');
    }
}
