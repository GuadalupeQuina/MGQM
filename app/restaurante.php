<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class restaurante extends Model
{
    protected $table = 'restaurante';
    protected $primaryKey = 'id';
    protected $fillable = [
    'nombre',
    'nosotros',
    'slogan1',
    'logo',
    'telefono1',
    'telefono2',
    'direccion',
    'email'
    ];

    public $timestamps = false;
}
