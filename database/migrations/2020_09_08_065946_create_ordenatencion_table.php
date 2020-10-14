<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenatencionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordenatencion', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->float('montoTotal');
            $table->boolean('estado');

            $table->integer('idUsuario')->unsigned();
            $table->integer('idCliente')->unsigned();
            $table->integer('idMesa')->unsigned();


            $table->foreign('idUsuario')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idCliente')->references('id')->on('cliente')->onDelete('cascade');
            $table->foreign('idMesa')->references('id')->on('mesa')->onDelete('cascade');

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordenatencion');
    }
}
