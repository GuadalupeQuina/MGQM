<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleordenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalleorden', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cantidad');
            $table->float('subTotal');

            $table->integer('idOrdenAtencion')->unsigned();
            $table->integer('idProducto')->unsigned();

            $table->foreign('idOrdenAtencion')->references('id')->on('ordenatencion')->onDelete('cascade');
            $table->foreign('idProducto')->references('id')->on('producto')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalleorden');
    }
}
