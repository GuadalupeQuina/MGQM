<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detallePedido extends Model
{
    protected $table = 'detallepedido';
    protected $primaryKey ='id';
    protected $fillable = [
        'cantidad',
        'subTotal',
        'idPedido',
        'idProducto',
    ];
    public $timestamps=false;
}
