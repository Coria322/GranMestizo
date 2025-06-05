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
        Schema::create('reportes', function (Blueprint $table) {
            $table->string('REPORTE_ID', 10)->primary();
            $table->string('REPORTE_CONTENIDO',255);
            $table->string('USUARIO_ID',10);
            
            $table->foreign('USUARIO_ID')
            ->references('USUARIO_ID')
            ->on('usuarios')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
