<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class listaMenu extends Model
{
    protected $table = 'listamenu';
    protected $primaryKey ='id';
    protected $fillable = [
        'estado',
        'idMenu',
        'idProducto',
    ];
    public $timestamps=false;
}
