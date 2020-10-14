<?php

namespace App\Http\Controllers;

use App\bitacora;
use App\categoria;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ctrlCategoria extends Controller{

    public function index(Request $request){
        
        //if(!$request->ajax()) return redirect('/');


        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $categoria= categoria::select('categoria.id','categoria.nombre')
            ->orderBy('categoria.id','desc')->paginate(10);
        }
        else{
            $categoria= categoria::select('categoria.id','categoria.nombre')
            ->where('categoria.'.$criterio, 'like', '%'.$buscar.'%')
            ->orderBy('categoria.id','desc')->paginate(10);            
        }
        
        $rol = auth()->user();
        $AuthRol = $rol;


        return [
            'pagination' => [
                'total'        => $categoria->total(),
                'current_page' => $categoria->currentPage(),
                'per_page'     => $categoria->perPage(),
                'last_page'    => $categoria->lastPage(),
                'from'         => $categoria->firstItem(),
                'to'           => $categoria->lastItem(),
            ],
            'categoria' => $categoria ,
            'rol'       => $AuthRol
        ];
    }
    public function store(Request $request){        
        try {
            DB::beginTransaction();
                $categoria = new categoria();
                $categoria->nombre = $request->nombre;
                $categoria->save();
                $bitacora = bitacora::guardar('categoria','guardar');
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }



    }
    public function update(Request $request){
        // if(!$request->ajax()) return redirect('/');
        $categoria= categoria::findOrFail($request->id);
	    $categoria->nombre = $request->nombre;

        $categoria->save();
        $bitacora = bitacora::guardar('categoria','actualizar');

    }
    public function delete(Request $request){

        $categoria= categoria::findOrFail($request->id);
        $bitacora = bitacora::guardar('categoria','eliminar');
        $categoria->delete();
    }
    public function selectCategoria(Request $request){
        
        $filtro = $request->filtro;
        if($filtro){
            $categoria = categoria::select('id','nombre')->orderBy('nombre', 'asc')->get();
        }else{
            $categoria = categoria::select('id','nombre')
            ->where('categoria.nombre', 'like', '%'. $filtro . '%')
            ->orderBy('nombre', 'asc')->get();
        }
        return ['categoria' => $categoria];

    }

    }
