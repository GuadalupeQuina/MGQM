<?php

namespace App;
 
use Illuminate\Database\Eloquent\Model;

class producto extends Model
{
    protected $table = 'producto';
    protected $primaryKey ='id';
    protected $fillable = [
        'descripcion',
        'foto',
        'nombre',
        'precio',
        'idCategoria'
    ];
    public $timestamps=false;
}




