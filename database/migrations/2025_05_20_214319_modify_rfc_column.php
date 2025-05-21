<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('CLIENTE_RFC', 13)->nullable()->change();
        });

        Schema::table('empleados', function (Blueprint $table) {
            $table->string('EMPLEADO_RFC', 13)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('CLIENTE_RFC', 13)->nullable(false)->change();
        });

        Schema::table('empleados', function (Blueprint $table) {
            $table->string('EMPLEADO_RFC', 13)->nullable(false)->change();
        });
    }
};