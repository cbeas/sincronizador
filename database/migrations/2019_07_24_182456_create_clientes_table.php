<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('id_cliente');
            $table->integer('id_memebresia');
            $table->bigInteger('id_tarjeta_principal');
            $table->integer('id_ubicacion_inicial');
            $table->string('nombre',255)->index();
            $table->string('paterno',80);
            $table->string('materno',80);
            $table->string('domicilio',255);
            $table->string('colonia',100);
            $table->string('cp',10);
            $table->integer('id_ciudad');
            $table->integer('id_estado');
            $table->boolean('persona_fisica');
            $table->string('rfc',16);
            $table->string('correo',100);
            $table->string('celular',32);
            $table->date('fecha_nacimiento');
            $table->string('sexo',5);
            $table->boolean('flotilla');
            $table->integer('estatus');
            $table->decimal('saldo',12,2);
            $table->text('notas');
            $table->dateTime('ultimo_consumo_cg');
            $table->dateTime('ultimo_consumo_cc');
            $table->dateTime('fecha_sync_saldo');
            $table->dateTime('fecha_actualizacion_saldo');
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
        Schema::dropIfExists('clientes');
    }
}
