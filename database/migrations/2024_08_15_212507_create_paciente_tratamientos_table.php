<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paciente_tratamientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->foreignId('tratamiento_id')->constrained('tratamientos')->onDelete('cascade');
            $table->string('trat_realizado', 100);
            $table->string('obs_trat', 255);
            $table->decimal('precio_trat', 10, 2);
            $table->decimal('acuenta_trat', 10, 2);
            $table->decimal('saldo_trat', 10, 2);
            $table->date('fecha_trat');
            $table->time('hora_trat');
            $table->string('estado_trat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paciente_tratamientos');
    }
};
