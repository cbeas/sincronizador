<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesSyncCgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes_sync_cg', function (Blueprint $table) {
            $table->bigInteger('id_cliente');            
            $table->integer('id_ubicacion');                        
            $table->dateTime('fecha_sync_cliente');
            $table->timestamps();

            $table->unique(['id_cliente', 'id_ubicacion']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes_sync_cg');
    }
}
