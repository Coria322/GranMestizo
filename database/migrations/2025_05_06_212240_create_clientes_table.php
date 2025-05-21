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
        Schema::create('clientes', function (Blueprint $table) {
            $table->char('USUARIO_ID', 10)->primary();
            $table->char('CLIENTE_RFC', 13)->unique();
            
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
        Schema::dropIfExists('clientes');
    }
};
