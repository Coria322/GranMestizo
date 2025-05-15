<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    public function run()
    {
        $clientes = Cliente::factory()->count(5)->create();

        $this->command->info("Se crearon {$clientes->count()} clientes:");
        foreach ($clientes as $cliente) {
            $this->command->line("- Usuario ID: {$cliente->USUARIO_ID} | RFC: {$cliente->CLIENTE_RFC}");
        }
    }
}
