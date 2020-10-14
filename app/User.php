<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;


    protected $fillable = [
        'name', 'email', 'password','nombre','apellidos'
    ];



    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $timestamps=false;

    static function rolUser(){
        
        $rol = Auth::user()->roles;
        $AuthRol = $rol[0]->name;
        
        return ["rol" => $AuthRol ];
    }


    static function autenticado(){
        
        $usuario = Auth::id(); 
        $rol = User::findOrFail($usuario);
        $rol->roles;


        return [
            "rol" => $rol,
            "autenticado" => Auth::user(),
            "idUser" => $usuario
        ];
    }
}
