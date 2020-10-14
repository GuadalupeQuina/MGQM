<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\categoria;
use App\producto;
use Faker\Generator as Faker;

$factory->define(producto::class, function (Faker $faker) {
    return [
        'descripcion'=> $faker->text,
        'foto'=>'distribution/img/dish-a.png',
        'nombre'=>$faker->name,
        'precio'=> 10,
        'idCategoria'=> factory(categoria::class)
    ];
});
