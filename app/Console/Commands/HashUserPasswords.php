<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class HashUserPasswords extends Command
{
    /**
     * El nombre y la descripción del comando.
     */
    protected $signature = 'usuarios:hash-passwords';

    protected $description = 'Hashea las contraseñas de los usuarios que no están hasheadas';

    /**
     * Ejecuta el comando.
     */
    public function handle()
    {
        // Obtén todos los usuarios
        $usuarios = Usuario::all();

        foreach ($usuarios as $usuario) {
            // Verifica si la contraseña necesita ser hasheada
            if (!Hash::needsRehash($usuario->USUARIO_PWD)) {
                $this->info("La contraseña del usuario con correo {$usuario->USUARIO_CORREO} ya está hasheada.");
                continue;
            }

            // Hashea la contraseña y guarda el usuario
            $usuario->USUARIO_PWD = Hash::make($usuario->USUARIO_PWD);
            $usuario->save();

            $this->info("Contraseña del usuario con correo {$usuario->USUARIO_CORREO} hasheada correctamente.");
        }

        $this->info('Todas las contraseñas han sido procesadas.');
    }
}
