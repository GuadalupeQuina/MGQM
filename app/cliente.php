<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cliente extends Model
{
    protected $table = 'cliente';
    protected $primaryKey ='id';
    protected $fillable = [
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
    public $timestamps=false;
}
