<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetCache extends Command
{
    protected $signature = 'cache:reset-all';
    protected $description = 'Limpia todas las cachés de configuración, rutas, vistas y la caché general';

    public function handle()
    {
        $this->info('⏳ Limpiando cachés...');

        $this->callSilent('config:clear');
        $this->callSilent('cache:clear');
        $this->callSilent('route:clear');
        $this->callSilent('view:clear');
        $this->callSilent('config:cache');

        $this->info('✅ Cachés limpiadas y reconfiguradas correctamente.');
    }
}
