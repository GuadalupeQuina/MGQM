<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    protected $table = 'menu';
    protected $primaryKey ='id';
    protected $fillable = [
        'fecha',
        'estado'
    ];
    public $timestamps=false;
}
