<?php

namespace App\Http\Controllers;

use App\tipo;
use Illuminate\Http\Request;

class ctrlTipo extends Controller
{
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $tipo= tipo::select('tipo.id','tipo.nombre')
            ->orderBy('tipo.id','desc')->paginate(10);
        }
        else{
            $tipo= tipo::select('tipo.id','tipo.nombre')
            ->where('tipo.'.$criterio, 'like', '%'.$buscar.'%')
            ->orderBy('tipo.id','desc')->paginate(10);            
        }
        
        return [
            'pagination' => [
                'total'        => $tipo->total(),
                'current_page' => $tipo->currentPage(),
                'per_page'     => $tipo->perPage(),
                'last_page'    => $tipo->lastPage(),
                'from'         => $tipo->firstItem(),
                'to'           => $tipo->lastItem(),
            ],
            'tipo' => $tipo
        ];
    }
    public function store(Request $request)
    {        
        $tipo = new tipo();
        $tipo->nombre = $request->nombre;
        $tipo->save();
    }
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tipo= tipo::findOrFail($request->id);
	    $tipo->nombre = $request->nombre;

        $tipo->save();
    }
    public function delete(Request $request)
    {
        $tipo= tipo::findOrFail($request->id);
        $tipo->delete();
    }
    public function selectTipo(){
        $tipo = tipo::select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['tipo' => $tipo];
    }


}
