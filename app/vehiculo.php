<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vehiculo extends Model
{
    protected $table='vehiculo';
    protected $primarykey='id';
    protected $fillable=[
        'tipoVehiculo',
        'caracteristicas',
        'placa',
        'idRepartidor'
    ];

    public $timestamps=false;
}
