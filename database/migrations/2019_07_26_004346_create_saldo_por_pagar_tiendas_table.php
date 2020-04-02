<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaldoPorPagarTiendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saldo_por_pagar_tiendas', function (Blueprint $table) {
            $table->bigIncrements('id_pp_tiendas');
            $table->bigInteger('id_mov_origen');
            $table->bigInteger('id_mov_destino');
            $table->integer('id_ubicacion_origen');
            $table->integer('id_ubicacion_destino');
            $table->decimal('monto',12,2);   
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
        Schema::dropIfExists('saldo_por_pagar_tiendas');
    }
}
