<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUbicacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ubicaciones', function (Blueprint $table) {
            $table->increments('id_ubicacion');
            $table->string('ubicacion',32);
            $table->boolean('estatus');
            $table->integer('id_tda');
            $table->integer('id_bd');
            $table->dateTime('sync_clientes');
            $table->dateTime('sync_tarjetas');
            $table->dateTime('sync_consumo');
            $table->dateTime('ultima_conexion');
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
        Schema::dropIfExists('ubicacions');
    }
}
