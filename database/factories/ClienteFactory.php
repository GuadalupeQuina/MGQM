<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\cliente;
use Faker\Generator as Faker;

$factory->define(cliente::class, function (Faker $faker) {
    return [
        'nombres',
        'apellidos',
        'login',
        'password',
        'empresa',
        'telefono',
        'direccion',
        'email',
        'estado'
    ];
});
