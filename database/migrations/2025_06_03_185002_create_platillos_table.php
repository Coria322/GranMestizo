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
        Schema::create('platillos', function (Blueprint $table) {
            $table->id('PLATILLO_ID');
            $table->string('PLATILLO_NOMBRE', 100);
            $table->text('PLATILLO_DESCRIPCION')->nullable();
            $table->string('PLATILLO_IMAGEN')->nullable(); // Ruta o nombre del archivo
            $table->enum('PLATILLO_STATUS', ['activo', 'inactivo'])->default('activo'); // Estado del platillo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platillos');
    }
};
