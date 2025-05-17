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
        Schema::create('reserva_mesa', function (Blueprint $table) {
            $table->increments('ID');
            $table->char('RESERVA_ID', 10);
            $table->char('MESA_ID', 10);
            $table->enum('STATUS', ['ACTIVO', 'INACTIVO'])->default('ACTIVO'); // o como prefieras
            $table->timestamps();

            $table->foreign('RESERVA_ID')
            ->references('RESERVA_ID')
            ->on('reservas')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            
            $table->foreign('MESA_ID')
            ->references('MESA_ID')
            ->on('mesas')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            // Índice único para evitar duplicados de la misma reserva y mesa
            $table->unique(['RESERVA_ID', 'MESA_ID']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserva_mesa');
    }
};
