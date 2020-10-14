<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCategoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
        });
        
        DB::table('categoria')->insert(array('nombre'=>'guisos'));
        DB::table('categoria')->insert(array('nombre'=>'ensaladas'));
        DB::table('categoria')->insert(array('nombre'=>'carne roja'));
        DB::table('categoria')->insert(array('nombre'=>'carne blanca'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categoria');
    }
}
