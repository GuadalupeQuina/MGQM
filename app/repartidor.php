<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class repartidor extends Model
{
    protected $table = 'repartidor';
    protected $primaryKey ='id';
    protected $fillable = [
        'nombre',
        'apellidos',
        'login',
        'password',
        'cedulaID',
        'telefono',
        'direccion'
    ];
    public $timestamps=false;
}
