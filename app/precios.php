<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class precios extends Model
{
    protected $table='precios';
    protected $primarykey='id';
    protected $fillable=[
        'precio',
        'fecha',
        'idProducto'
    ];

    public $timestamps=false;
}
