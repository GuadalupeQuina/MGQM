<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListamenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listamenu', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('estado')->default(1);
            $table->integer('idMenu')->unsigned();
            $table->integer('idProducto')->unsigned();

            $table->foreign('idMenu')->references('id')->on('menu')->onDelete('cascade');
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
        Schema::dropIfExists('listamenu');
    }
}
