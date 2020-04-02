<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosSaldoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos_saldo', function (Blueprint $table) {
            $table->bigIncrements('id_mov');
            $table->bigInteger('id_cliente');
            $table->bigInteger('id_tarjeta');
            $table->integer('id_ubicacion');
            $table->integer('id_consumo');
            $table->string('tipo',20);
            $table->string('origen',20);
            $table->decimal('monto',12,2);
            $table->decimal('saldo_pendiente',12,2);
            $table->decimal('saldo_anterior',12,2);
            $table->decimal('saldo_nuevo',12,2);
            $table->string('regla',128);
            $table->string('folio',50);
            $table->decimal('consumo',12,2);
            $table->string('tipo_usuario',5);
            $table->string('email_usuario',100);
            $table->dateTime('fecha_consumo');
            $table->dateTime('fecha_mov');            
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
        Schema::dropIfExists('movimientos_saldo');
    }
}
