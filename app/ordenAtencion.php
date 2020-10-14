<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ordenAtencion extends Model
{
    protected $table = 'ordenatencion';
    protected $primaryKey ='id';
    protected $fillable = [
        'fecha',
        'montoTotal',
        'estado',
        'idUsuario',
        'idCliente',
        'idMesa',
    ];
    public $timestamps=false;
}
