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
        Schema::create('mesas', function (Blueprint $table) {
            $table->char('MESA_ID', 10)->primary();
            $table->unsignedInteger('MESA_CAPACIDAD');
            $table->enum('MESA_STATUS', ['LIBRE', 'OCUPADO'])->default('LIBRE');
            $table->string('MESA_SECCION', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesas');
    }
};
