<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detalleOrden extends Model
{
    protected $table = 'detalleorden';
    protected $primaryKey ='id';
    protected $fillable = [
        'cantidad',
        'subTotal',
        'idOrdenAtencion',
        'idProducto',
    ];
    public $timestamps=false;
}
