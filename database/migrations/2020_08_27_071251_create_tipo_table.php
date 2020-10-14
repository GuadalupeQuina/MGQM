<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
//use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTipoTable extends Migration
{

    public function up()
    {
        Schema::create('tipo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
        });

     //   DB::table('tipo')->insert(array('nombre' => 'administrador'));
     //   DB::table('tipo')->insert(array('nombre' => 'cliente'));
     //   DB::table('tipo')->insert(array('nombre' => 'repartidor'));
        // DB::table('tipo')->insert(array('repartidor'));
    }

    public function down()
    {
        Schema::dropIfExists('tipo');
    }
}
