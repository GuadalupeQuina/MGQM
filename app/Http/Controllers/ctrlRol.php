<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Role as ModelsRole;

class ctrlRol extends Controller
{
    public function rolUser(){
        $roles = ModelsRole::all();
        return ["rol"=>$roles];
    }
}