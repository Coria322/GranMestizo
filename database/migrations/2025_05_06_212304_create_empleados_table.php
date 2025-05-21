<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->char('USUARIO_ID', 10)->primary(); // Relación 1:1
            $table->char('EMPLEADO_RFC', 13);
            $table->enum('EMPLEADO_TURNO', ['M', 'V'])->default('M'); 
            $table->enum('EMPLEADO_STATUS', ['LIBRE', 'OCUPADO'])->default('LIBRE');
            
            $table->foreign('USUARIO_ID')
                  ->references('USUARIO_ID')
                  ->on('usuarios')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
