<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallepedidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallepedido', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cantidad');
            $table->float('subTotal');

            $table->integer('idPedido')->unsigned();
            $table->integer('idProducto')->unsigned();

            $table->foreign('idPedido')->references('id')->on('pedido')->onDelete('cascade');
            $table->foreign('idProducto')->references('id')->on('producto')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detallepedido');
    }
}
