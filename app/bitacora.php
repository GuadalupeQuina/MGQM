<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bitacora extends Model
{
    protected $table = 'bitacora';
    protected $primaryKey ='id';
    protected $fillable = [
        'fecha',
        'hora',
        'tabla',
        'transaccion',
        'idUsuario'
    ];
    public $timestamps=false;

    static function guardar($tabla,$transaccion){
       
        $idUsuario = auth()->id();

        $fecha = date('Y-m-d');
        $hora = date('H:i:s');

        $bitacora = new bitacora();
        $bitacora->fecha = $fecha;
        $bitacora->hora = $hora;
        $bitacora->tabla = $tabla;
        $bitacora->transaccion = $transaccion;
        $bitacora->idUsuario =  $idUsuario;
        $bitacora->save();
    }
}
