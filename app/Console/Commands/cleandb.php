<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class cleandb extends Command
{
    protected $signature = 'app:cleandb';

    protected $description = 'Limpia todos los datos de la base de datos sin eliminar las tablas';

    public function handle()
    {
        $this->info('Iniciando limpieza de la base de datos...');

        // Desactivar claves foráneas para evitar errores
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Obtener todas las tablas
        $tables = DB::select('SHOW TABLES');

        $key = 'Tables_in_' . env('DB_DATABASE'); // Nombre del campo con las tablas, depende del nombre de la base

        foreach ($tables as $table) {
            $tableName = $table->$key;
            // Vaciar tabla
            DB::table($tableName)->truncate();
            $this->info("Tabla $tableName truncada.");
        }

        // Reactivar claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->info('Base de datos limpiada correctamente.');
    }
}
