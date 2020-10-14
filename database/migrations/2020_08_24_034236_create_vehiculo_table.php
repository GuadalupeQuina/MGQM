<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipoVehiculo')->nullable();
            $table->string('caracteristicas',50);
            $table->string('placa',50);

            $table->integer('idRepartidor')->unsigned();
            $table->foreign('idRepartidor')->references('id')->on('repartidor')->onDelete('cascade');
        });    
    }
    public function down()
    {
        Schema::dropIfExists('vehiculo');
    }
}
