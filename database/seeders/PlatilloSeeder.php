<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Platillo;

class PlatilloSeeder extends Seeder
{
    public function run(): void
    {
        Platillo::factory()->count(10)->create();
        $this->command->info('✅ Se crearon 10 platillos de prueba.');
    }
}
