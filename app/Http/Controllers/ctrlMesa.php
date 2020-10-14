<?php

namespace App\Http\Controllers;

use App\bitacora;
use App\mesa;
use Illuminate\Http\Request;

class ctrlMesa extends Controller
{



    public function mostrar(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $mesa= mesa::select('mesa.id as id','mesa.capacidad','descripcion','ocupado','ubicacion')
            ->orderBy('mesa.id','desc')
            ->paginate(8);
        }
        else{
            $mesa= mesa::select('mesa.id','mesa.capacidad','descripcion','ocupado','ubicacion')
            ->where('mesa.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('mesa.id','desc')
            ->paginate(8);            
        }
        
        return [
            'pagination' => [
                'total'        => $mesa->total(),
                'current_page' => $mesa->currentPage(),
                'per_page'     => $mesa->perPage(),
                'last_page'    => $mesa->lastPage(),
                'from'         => $mesa->firstItem(),
                'to'           => $mesa->lastItem(),
            ],
            'mesa' => $mesa
        ];
    }
    public function guardar(Request $request){        
        $mesa = new mesa();
        $mesa->capacidad = $request->capacidad;
        $mesa->descripcion = $request->descripcion;
        $mesa->ocupado = 0;
        $mesa->ubicacion = $request->ubicacion;
        $mesa->save();

        $bitacora = bitacora::guardar('mesa','guardar');
    }
    public function modificar(Request $request){
        // if(!$request->ajax()) return redirect('/');
        $mesa = mesa::findOrFail($request->id);
        $mesa->capacidad = $request->capacidad;
        $mesa->descripcion = $request->descripcion;
        $mesa->ocupado = 0;
        $mesa->ubicacion = $request->ubicacion;
        $mesa->save();

        $bitacora = bitacora::guardar('mesa','actualizar');

    }
    public function eliminar(Request $request){
        $mesa= mesa::findOrFail($request->id);
        $mesa->delete();

        $bitacora = bitacora::guardar('mesa','eliminar');

    }
    public function libre(Request $request){
        $mesa= mesa::findOrFail($request->id);
        $mesa->ocupado = 0;
        $mesa->update();
    }
    public function ocupado(Request $request){
        $mesa= mesa::findOrFail($request->id);
        $mesa->ocupado = 1;
        $mesa->update();
    }
}
