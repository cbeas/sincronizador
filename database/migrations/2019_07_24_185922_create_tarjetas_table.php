<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTarjetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarjetas', function (Blueprint $table) {
            $table->bigInteger('id_tarjeta')->unique();
            $table->bigInteger('id_cliente');
            $table->string('tarjeta',32)->unique();
            $table->string('nombre',255);
            $table->boolean('adicional');
            $table->boolean('estatus');
            $table->decimal('saldo_migracion',12,2);            
            $table->dateTime('fecha_sync_update_tarjeta');
            $table->dateTime('fecha_sync_por_migrar');
            $table->dateTime('fecha_sync_saldo_inicial');
            $table->dateTime('fecha_creacion');
            $table->dateTime('fecha_actualizacion');
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
        Schema::dropIfExists('tarjetas');
    }
}
