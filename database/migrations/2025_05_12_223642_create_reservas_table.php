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
        Schema::create('reservas', function (Blueprint $table) {
            $table->string('RESERVA_ID', 10)->primary();

            
            $table->string('CLIENTE_ID', 10);
            $table->foreign('CLIENTE_ID')
                ->references('USUARIO_ID')
                ->on('clientes')
                ->onUpdate('cascade')  // Actualizar en cascada si cambia ID
                ->onDelete('restrict'); // No permitir borrar si hay reservas

            $table->unsignedInteger('RESERVA_COMENSALES')->default(1);

            $table->date('RESERVA_FECHA');
            $table->time('RESERVA_HORA');

            
            $table->string('EMPLEADO_ID', 10)->nullable();
            $table->foreign('EMPLEADO_ID')
                ->references('USUARIO_ID')
                ->on('empleados')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
