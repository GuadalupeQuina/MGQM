<?php

namespace App\Http\Controllers;

use App\bitacora;
use Illuminate\Http\Request;

class ctrlBitacora extends Controller
{
    public function mostrar(Request $request){
        // if(!$request->ajax()) return redirect('/');
        
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $bitacora= bitacora::select('bitacora.id','bitacora.fecha','hora','tabla','transaccion','idUsuario')
            ->orderBy('bitacora.id','desc')->paginate(10);
        }
        else{
            $bitacora= bitacora::select('bitacora.id','bitacora.fecha','hora','tabla','transaccion','idUsuario')
            ->where('bitacora.'.$criterio, 'like', '%'.$buscar.'%')
            ->orderBy('bitacora.id','desc')->paginate(10);            
        }
        
        return [
            'pagination' => [
                'total'        => $bitacora->total(),
                'current_page' => $bitacora->currentPage(),
                'per_page'     => $bitacora->perPage(),
                'last_page'    => $bitacora->lastPage(),
                'from'         => $bitacora->firstItem(),
                'to'           => $bitacora->lastItem(),
            ],
            'bitacora' => $bitacora
        ];
    }
}
