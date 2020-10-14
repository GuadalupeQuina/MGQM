<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ubicacion extends Model
{
    protected $table = 'ubicacion';
    protected $primaryKey ='id';
    protected $fillable = [
        'latitud',
        'longitud',
        'referencia',
        'url'
    ];
    public $timestamps=false;
}

