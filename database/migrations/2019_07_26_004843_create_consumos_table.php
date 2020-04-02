<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsumosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumos', function (Blueprint $table) {

            $table->bigIncrements('id_consumo');
            $table->string('origen',20);
            $table->integer('id_ubicacion');
            $table->string('hash_local',128);
            $table->bigInteger('id_cliente');
            $table->bigInteger('id_tarjeta');
            $table->string('folio',50);
            $table->decimal('monto',12,2);
            $table->string('tipo',20);
            $table->dateTime('fecha_consumo');
            $table->dateTime('fecha_sync_consumo');
            $table->dateTime('fecha_revision')->nullable();            
            $table->timestamps();

            $table->unique(['origen', 'id_ubicacion','hash_local']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consumos');
    }
}
