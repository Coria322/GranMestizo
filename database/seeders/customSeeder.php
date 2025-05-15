<?php

namespace Database\Seeders;

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
            UsuarioSeeder::class,
          // AdminSeeder::class,
            // ClienteSeeder::class,
            // EmpleadoSeeder::class
        ]);

        $this->command->info('Todos los datos iniciales fueron sembrados correctamente.');
    }
}
