<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Administrador;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $admins = Administrador::factory()->count(5)->create();

        $this->command->info("Se crearon {$admins->count()} administradores:");
        foreach ($admins as $admin) {
            $this->command->line("- Usuario ID: {$admin->USUARIO_ID}");
        }
    }
}
