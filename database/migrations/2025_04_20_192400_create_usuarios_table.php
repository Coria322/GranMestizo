<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->char('USUARIO_ID', 10)->primary(); 
            $table->string('USUARIO_NOMBRE', 50);
            $table->string('USUARIO_APELLIDO', 50);
            $table->string('USUARIO_CORREO', 100)->unique();
            $table->string('USUARIO_PWD', 255);
            $table->enum('USUARIO_ROL', ['ADMINISTRADOR', 'EMPLEADO', 'CLIENTE'])->default('CLIENTE');
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
