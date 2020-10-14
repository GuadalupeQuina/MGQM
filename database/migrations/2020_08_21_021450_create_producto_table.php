<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->increments('id');
            $table->text('descripcion')->nullable();
            $table->string('foto');
            $table->string('nombre',50);
            $table->float('precio');

            $table->integer('idCategoria')->unsigned();
            $table->foreign('idCategoria')->references('id')->on('categoria')->onDelete('cascade');
        });
        

        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/plato1.png','nombre'=>'Pollo a la Brasa','precio'=>10,'idCategoria'=>4));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/plato1.png','nombre'=>'Pollo a la Broaster','precio'=>10,'idCategoria'=>4));


        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/plato1.png','nombre'=>'Carne asada','precio'=>10,'idCategoria'=>3));


        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/plato2.png','nombre'=>'Guiso de arroz','precio'=>10,'idCategoria'=>1));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/plato2.png','nombre'=>'Guiso de fideo','precio'=>10,'idCategoria'=>1));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/plato2.png','nombre'=>'Guiso de argentino','precio'=>10,'idCategoria'=>1));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/plato2.png','nombre'=>'Guiso con verduraz','precio'=>10,'idCategoria'=>1));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/plato2.png','nombre'=>'Guiso con carne','precio'=>10,'idCategoria'=>1));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/plato2.png','nombre'=>'Guiso con pollo','precio'=>10,'idCategoria'=>1));

        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/plato3.png','nombre'=>'ensaladas de arroz salvaje','precio'=>10,'idCategoria'=>2));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/plato3.png','nombre'=>'ensaladas de lenteja'      ,'precio'=>10,'idCategoria'=>2));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/plato3.png','nombre'=>'ensaladas de chmpiñones','precio'=>10,'idCategoria'=>2));
       
    }
    public function down()
    {
        Schema::dropIfExists('producto');
    }
}
