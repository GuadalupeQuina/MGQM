<?php

namespace App\Http\Controllers;

use App\bitacora;
use App\categoria;
use App\listaMenu;
use Illuminate\Http\Request;
use App\producto;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ctrlProducto extends Controller{
    
    
    public function mostrar(Request $request){
        
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $producto = producto::join('categoria','producto.idCategoria','=','categoria.id')
            ->select('producto.id',
                     'producto.idCategoria',
                     'producto.nombre',
                     'producto.precio',
                     'producto.foto',
                     'categoria.nombre as categoria',
                     'producto.descripcion'
                     )
            ->orderBy('producto.id', 'desc')->paginate(10);
        }
        else{
            
            $producto = producto::join('categoria','producto.idCategoria','=','categoria.id')
            ->select(   'producto.id',
                        'producto.idCategoria',
                        'producto.nombre',
                        'producto.precio',
                        'producto.foto',
                        'categoria.nombre as categoria',
                        'producto.precio',
                        'producto.descripcion'
                        )
            ->where($criterio.'.nombre', 'like', '%'. $buscar . '%')
            ->orderBy('producto.id', 'desc')->paginate(10);
        }
        

        return [
            'pagination' => [
                'total'        => $producto->total(),
                'current_page' => $producto->currentPage(),
                'per_page'     => $producto->perPage(),
                'last_page'    => $producto->lastPage(),
                'from'         => $producto->firstItem(),
                'to'           => $producto->lastItem(),
            ],
            'producto' => $producto,
        ];
    }
    
    public function buscarProducto(Request $request){
        // if (!$request->ajax()) return redirect('/');

        $buscar   = $request->buscar;
        $criterio = $request->criterio;
       


        
        if ($buscar==''){
            $producto = producto::join('categoria','producto.idCategoria','=','categoria.id')
            ->select('producto.id',
                     'producto.idCategoria',
                     'producto.nombre',
                     'producto.precio',
                     'producto.foto',
                     'categoria.nombre as categoria',
                     'producto.descripcion'
                     )
            ->orderBy('producto.id', 'desc')->paginate(5);
        }
        else{
            
            $producto = producto::join('categoria','producto.idCategoria','=','categoria.id')
            ->select('producto.id',
                        'producto.idCategoria',
                        'producto.nombre',
                        'producto.precio',
                        'producto.foto',
                        'categoria.nombre as categoria',
                        'producto.precio',
                        'producto.descripcion'
                        )
            ->where($criterio.'.nombre', 'like', '%'. $buscar . '%')
            ->orderBy('producto.id', 'desc')->paginate(5);
        }
        

        return [
            'producto' => $producto
        ];
    }

    public function buscarProductoCategoria(Request $request){
        
        $buscar    = $request->buscar;
        $criterio  = $request->criterio;
        $idCategoria = $request->idCategoria;
        
        if($criterio==''){
            $criterio ='producto'; 
        }

        
        if ($buscar==''){
            $producto = producto::join('categoria','producto.idCategoria','=','categoria.id')
            ->select('producto.id',
                     'producto.idCategoria',
                     'producto.nombre',
                     'producto.precio',
                     'producto.foto',
                     'categoria.nombre as categoria',
                     'producto.descripcion'
                     )
            ->where('producto.idCategoria','=',$idCategoria)
            ->orderBy('producto.id', 'desc')->paginate(5);
        }
        else{
            
            $producto = producto::join('categoria','producto.idCategoria','=','categoria.id')
            ->select('producto.id',
                        'producto.idCategoria',
                        'producto.nombre',
                        'producto.precio',
                        'producto.foto',
                        'categoria.nombre as categoria',
                        'producto.precio',
                        'producto.descripcion'
                        )
            ->where($criterio.'.nombre' , 'like', '%'. $buscar . '%')
            ->where('producto.idCategoria','=',$idCategoria)
            ->orderBy('producto.id', 'desc')->paginate(5);
        }
        

        return [
            'producto' => $producto
        ];
    }

    public function menuProducto(Request $request){
        // if (!$request->ajax()) return redirect('/');

        $buscar   = $request->buscar;
        $criterio = $request->criterio;
       


        
        if ($buscar==''){
            $producto = listaMenu::join('producto','producto.id','=','listamenu.idProducto')
            ->join('menu','menu.id','listamenu.idMenu')
            ->select('producto.id as idProducto',
                     'listamenu.id',
                     'producto.idCategoria',
                     'producto.nombre',
                     'producto.precio',
                     'producto.foto',
                     'producto.descripcion'
                     )
            ->orderBy('producto.id', 'desc')
            ->where('menu.estado','=',1)
            ->paginate(5);
        }
        else{
            
            $producto = listaMenu::join('producto','producto.id','=','listamenu.idProducto')
            ->join('menu','menu.id','listamenu.idMenu')
            ->select('producto.id as idProducto',
                        'listamenu.id',
                        'producto.idCategoria',
                        'producto.nombre',
                        'producto.precio',
                        'producto.foto',
                        'producto.precio',
                        'producto.descripcion'
                        )
            ->where('menu.estado','=',1)
            ->where('producto.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('producto.id', 'desc')->paginate(5);
        }
        

        return [
            'producto' => $producto
        ];
    }
    public function selectProducto(Request $request){
        
        // if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $categoria = $request->idCategoria;
        $productos = producto::select('id as idProducto','precio','foto','descripcion','nombre')
        ->where('idCategoria','=',$categoria)
        ->where('producto.nombre', 'like', '%'. $filtro . '%')
        ->orderBy('producto.nombre', 'asc')->get();

        return ['productos' => $productos];
    }
    public function guardar(Request $request){
        // if (!$request->ajax()) return redirect('/');
        $producto = new producto();
        $producto->idCategoria = $request->idCategoria;
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;

        if($request->file('foto')){
            $path = Storage::disk('public')->put('imagenes',$request->file('foto'));
            $producto->foto = $path; 
        }else{
            $producto->foto = 'imagenes/plato1.png';
        }
        $producto->descripcion = $request->descripcion;
        $producto->save();

        $bitacora = bitacora::guardar('producto','guardar');


    }
    public function modificar(Request $request){

        // if (!$request->ajax()) return redirect('/');
        
        $producto = producto::findOrFail($request->id);
        $producto->idCategoria = $request->idCategoria;
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;

        if($request->file('foto')){
            $path = Storage::disk('public')->put('imagenes',$request->file('foto'));
            $producto->foto = $path; 
        }

        $producto->descripcion = $request->descripcion;
        $producto->update();

        $bitacora = bitacora::guardar('producto','actualizar');

    }
    public function eliminar(Request $request){
        // if (!$request->ajax()) return redirect('/');
        $producto = producto::findOrFail($request->id);
        $producto->delete();

        $bitacora = bitacora::guardar('producto','eliminar');


    }
    public function productoMenu(Request $request){
        $id = $request->id;
        $productoMenu = listaMenu::join('menu','menu.id','=','listamenu.idMenu')
                                ->join('producto','producto.id','listamenu.idProducto')
                                ->select('producto.id','producto.foto','producto.nombre','producto.precio','listamenu.estado')->where('menu.id','=',$id)->get(); 
        return [
            'productoMenu'=> $productoMenu
        ];
    }

    public function listaMenuProducto(Request $request){
        
        $criterio = $request->criterio;
        
        $productoMenu = listaMenu::join('menu','menu.id','=','listamenu.idMenu')
        ->join('producto','producto.id','listamenu.idProducto')
        ->select('producto.id as idProducto','producto.foto','producto.nombre','producto.precio','listamenu.estado')->where('menu.id','=',$criterio)->get(); 
        

        return [
        'productoMenu'=> $productoMenu
        ];
    }

}