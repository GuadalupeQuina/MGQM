<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration{
    
    public function up(){

        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha')->nullable();
            $table->boolean('estado')->default(0);

            $table->integer('idCategoria')->unsigned();
            $table->foreign('idCategoria')->references('id')->on('categoria')->onDelete('cascade');
        });
    }

    public function down(){

        Schema::dropIfExists('menu');
    }
}
