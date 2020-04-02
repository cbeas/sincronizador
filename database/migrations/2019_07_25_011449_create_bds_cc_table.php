<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBdsCcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bds_cc', function (Blueprint $table) {
           $table->increments('id_bd');
            $table->string('nombre',128);
            $table->string('bd',128);
            $table->boolean('estatus');
            $table->string('last_message',255);
            $table->dateTime('ultima_conexion');
            $table->dateTime('fecha_actualizacion');
            $table->dateTime('fecha_sync_bd');
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
        Schema::dropIfExists('bd_ccs');
    }
}
