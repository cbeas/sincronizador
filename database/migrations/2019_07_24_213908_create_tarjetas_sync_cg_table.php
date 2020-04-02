<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTarjetasSyncCgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarjetas_sync_cg', function (Blueprint $table) {

            $table->bigInteger('id_tarjeta');            
            $table->integer('id_ubicacion');                        
            $table->dateTime('fecha_sync_tarjeta');
            $table->timestamps();

            $table->unique(['id_tarjeta', 'id_ubicacion']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarjetas_sync_cg');
    }
}
