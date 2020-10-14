<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreciosTable extends Migration
{
   
    public function up()
    {
        Schema::create('precios', function (Blueprint $table) {
            $table->increments('id');
            $table->float('precio',100);
            $table->date('fecha');

            $table->integer('idProducto')->unsigned();
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
        Schema::dropIfExists('precios');
    }
}
