<?php

namespace App\Http\Controllers;

use App\bitacora;
use App\listaMenu;
use App\menu;
use App\precios;
use App\producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ctrlMenu extends Controller
{
    public function mostrar(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $menu= menu::join('categoria','categoria.id','=','menu.idCategoria')
            ->select('categoria.nombre as categoria','menu.id','estado','menu.fecha')
            ->orderBy('menu.id','desc')->paginate(20);
        }
        else{
            $menu= menu::join('categoria','categoria.id','=','menu.idCategoria')
            ->select('categoria.nombre as categoria','menu.id','estado','menu.fecha')
            ->where('menu.'.$criterio,'=',$buscar)
            ->orderBy('menu.id','desc')->paginate(20);            
        }
        
        return [
            'pagination' => [
                'total'        => $menu->total(),
                'current_page' => $menu->currentPage(),
                'per_page'     => $menu->perPage(),
                'last_page'    => $menu->lastPage(),
                'from'         => $menu->firstItem(),
                'to'           => $menu->lastItem(),
            ],
            'menus' => $menu
        ];
    }
    public function existeMenu($fecha,$categoria){

        $fecha      = '2020-10-01';
        $sw         = false;
        $categoria  = 1;


        $menu = menu::select('fecha')
                    ->where('idCategoria','=',$categoria)
                    ->where('fecha','=',$fecha)
                    ->get();

        $count = count($menu);
        
        if($count){
            $sw=true;
        }
        return ["existe"=> $sw];
    }   
    public function guardar(Request $request){

        $menus = menu::where('idCategoria','=',$request->idCategoria)
                ->where('fecha','=',$request->fecha)
                ->get();

        foreach ($menus as $key => $value) {
            $value->estado = 0;
            $value->update();
        }

        $bitacora = bitacora::guardar('menu','actualizar');


        
        $menu = new menu();
        $menu->fecha = $request->fecha;
        $menu->estado=1;
        $menu->idCategoria =  $request->idCategoria;
        $menu->save();
        $bitacora = bitacora::guardar('menu','guardar');

        $listaMenu = $request->data;

        foreach($listaMenu as $ep=>$det){
            
            $precio = new precios();
            $precio->fecha = $request->fecha;
            $precio->precio = $det['precio'] ;
            $precio->idProducto = $det['id'];
            $precio->save();
            $bitacora = bitacora::guardar('precios','guardar');


            $producto = producto::findOrFail($det['id']);
            $producto->precio = $precio->precio;
            $producto->update(); 
            $bitacora = bitacora::guardar('producto','actualizar');




            $listaMenu = new listaMenu();
            $listaMenu->estado = 1;
            $listaMenu->idProducto = $det['id'];

            $listaMenu->idMenu = $menu->id;
            $listaMenu->save();

            $bitacora = bitacora::guardar('listaMenu','guardar');


        }    



    }
    public function activar(Request $request){

        $menu= menu::findOrFail($request->id);

        $menus = menu::where('idCategoria','=',$menu->idCategoria)
        ->where('fecha','=',$menu->fecha)
        ->get();

        foreach ($menus as $key => $value) {
            $value->estado = 0;
            $value->update();
        }

        $menu->estado = 1;
        $menu->update();
        $bitacora = bitacora::guardar('menu','actualizar-estado');
    }
    public function desactivar(Request $request){
        
        $menu= menu::findOrFail($request->id);
        $menu->estado = 0;
        $menu->update();
        $bitacora = bitacora::guardar('menu','actualizar-estado');
        
    }
    public function eliminarMenu(Request $request){
        $menu = menu::findOrFail($request->id);
        $menu->delete();
    }
    public function allMenus(){
        
        $fecha = date('Y-m-d');
        $menus = menu::select('menu.id','categoria.nombre as categoria','menu.idCategoria','menu.fecha','menu.estado')
        ->join('categoria','categoria.id','=','menu.idCategoria')
        ->where('fecha','=',$fecha)
        ->get();
        return ["menu"=>$menus];
    }
}
