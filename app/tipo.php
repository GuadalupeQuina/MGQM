<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipo extends Model
{
    
    protected $table = 'tipo';
    protected $primaryKey = 'id';
    protected $fillable = [
    'nombre'
    ];

    public $timestamps = false;
}
