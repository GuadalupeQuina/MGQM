<?php

namespace App\Http\Controllers;

use App\producto;
use App\restaurante;
use Illuminate\Http\Request;

class ctrlRestaurante extends Controller
{
    public function welcome(){

        $fechaActual = date('Y-m-d');

        
        // return $fechaActual;
        $menu = 
        $restaurante = restaurante::all();
        $platos = producto::all();
        

        return view('welcome',[
            'restaurante'=> $restaurante,
            'platos'=>$platos
        ]);
    }
    public function index(){
        return view('modules.restaurante.frmRestaurante');
    }
    public function create(){
        return view('modules.restaurante.frmCreate');
    }
}
