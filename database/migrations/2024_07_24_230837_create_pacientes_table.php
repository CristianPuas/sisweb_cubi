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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombres_pc', 70);
            $table->string('ap_pat_pc',50);
            $table->string('ap_mat_pc',50);
            $table->integer('edad');
            $table->string('tel_pac',15);
            $table->string('direccion_pc', 255);
            $table->string('ci_pc', 15);
            $table->string('genero_pc',20);
            $table->string('trat_realizado', 100);
            $table->string('obs_trat', 255);
            $table->decimal('precio_trat', 10, 2);
            $table->decimal('acuenta_trat', 10, 2);
            $table->decimal('saldo_trat', 10, 2);
            $table->date('fecha_trat');
            $table->time('hora_trat');
            $table->string('estado_trat');
            $table->foreignId('consulta_id')->nullable()->constrained('consultas')->onDelete('cascade');
            $table->foreignId('tratamiento_id')->nullable()->constrained('tratamientos')->onDelete('cascade');
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
        Schema::dropIfExists('pacientes');
    }
};
