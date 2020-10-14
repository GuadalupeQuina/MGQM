<?php

namespace App\Http\Controllers;

use App\bitacora;
use App\cliente;
use App\detalleOrden;
use App\mesa;
use Illuminate\Http\Request;
use App\ordenAtencion;
use App\producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ctrlOrdenAtencion extends Controller
{
    public function guardar(Request $request){

            $id = auth()->id();

            $ordenAtencion = new ordenAtencion();
            $ordenAtencion->estado = 1;
            $ordenAtencion->idUsuario = $id;
            $ordenAtencion->idCliente = $request->idCliente;
            $ordenAtencion->idMesa = $request->idMesa;
            $ordenAtencion->montoTotal = 0;
            $ordenAtencion->fecha= date('Y-m-d');
            $ordenAtencion->save();

            $bitacora = bitacora::guardar('ordenAtencion','guardar');

            $detalle = $request->data;
            $total = 0;

            foreach($detalle as $ep=>$det)
            {
                
                $detalle = new detalleOrden();
                $detalle->cantidad = $det['cantidad'];
                $detalle->idProducto = $det['idProducto'];
                $detalle->idOrdenAtencion = $ordenAtencion->id;
                $detalle->subTotal = ($det['cantidad']*$det['precio']);
                $detalle->save();
                $bitacora = bitacora::guardar('detalleOrden','guardar');

                $total = $total + ($det['cantidad']*$det['precio']);
            }    

            $ordenAtencion->montoTotal = $total;
            $ordenAtencion->update();
            $bitacora = bitacora::guardar('ordenAtencion','actualizar');



            $mesa = mesa::findOrFail($request->idMesa);
            $mesa->ocupado = 1; 
            $mesa->update();

            $bitacora = bitacora::guardar('mesa','actualizar');

    }
    public function buscarDetalle(Request $request){



        $id = $request->filtro;

        $detalle = detalleOrden::join('ordenatencion','ordenatencion.id','=','detalleorden.idOrdenAtencion')
        ->join('producto','producto.id','=','detalleorden.idProducto')->select('detalleorden.id as idDetalle',
        'detalleorden.cantidad','detalleorden.id','detalleorden.idProducto','detalleorden.idOrdenAtencion'
        ,'producto.precio','producto.foto','producto.nombre','ordenatencion.idMesa'
        )
        ->where('ordenatencion.idMesa','=',$id)->where('ordenatencion.estado','=',1)
        ->get();


        $cliente = ordenAtencion::join('cliente','cliente.id','=','ordenatencion.idCliente')
        ->join('mesa','mesa.id','=','ordenatencion.idMesa')->where('mesa.id','=',$id)
        ->select(DB::raw('CONCAT(nombres, " ", apellidos) as nombreCompleto'),'cliente.id','empresa')->where('ordenatencion.estado','=',1)
        ->get();
        
 
        


        $orden = ordenAtencion::where('ordenatencion.id','=',$detalle[0]->idOrdenAtencion)->get(); 

        
        $total = $orden[0]->montoTotal;

        return ['detalle'         => $detalle,
                'cliente'         => $cliente,
                'idMesa'          => $detalle[0]->idMesa,
                'idCliente'       => $cliente[0]->id,
                'idOrdenAtencion' => $detalle[0]->idOrdenAtencion ,
                'orden'           => $orden,
                'nombreCompleto'  => $cliente[0]->nombreCompleto,
                'montoTotal'      => $total
                ];
    }
    public function modificarDetalle(Request $request){
        
        
        $id = auth()->id();

        $ordenAtencion = ordenAtencion::findOrFail($request->idOrdenAtencion);
        $ordenAtencion->estado = 1;
        $ordenAtencion->idUsuario = $id;
        $ordenAtencion->idCliente = $request->idCliente;
        $ordenAtencion->idMesa = $request->idMesa;
        $ordenAtencion->montoTotal = 0;
        $ordenAtencion->fecha= date('Y-m-d');
        $ordenAtencion->update();
        $bitacora = bitacora::guardar('ordenAtencion','actualizar');



        $detalle = $request->data;
        $total = 0;

        foreach($detalle as $ep=>$det)
        {
            
            $detalle = detalleOrden::findOrFail($det['idDetalle']);
            $detalle->cantidad = $det['cantidad'];
            $detalle->idProducto = $det['idProducto'];
            $detalle->idOrdenAtencion = $request->idOrdenAtencion;
            $detalle->update();

            $bitacora = bitacora::guardar('detalleOrden','actualizar');


            $total = $total + ($det['cantidad']*$det['precio']);
        }    

        $ordenAtencion->montoTotal = $total;
        $ordenAtencion->update();



        $mesa = mesa::findOrFail($request->idMesa);
        $mesa->ocupado = 1; 
        $mesa->update();
        $bitacora = bitacora::guardar('mesa','actualizar');

    }
    public function itemEliminar(Request $request){
         
        $detalleOrden= detalleOrden::findOrFail($request->id);
        $idProducto = $detalleOrden->idProducto;

        $producto = producto::findOrFail($idProducto);
        $precioProducto = $producto->precio;
        
        $subTotal =  $detalleOrden->cantidad * $precioProducto;
        
        $idOrdenAtencion = $detalleOrden->idOrdenAtencion;
        $ordenAtencion = ordenAtencion::findOrFail($idOrdenAtencion);

        $ordenAtencion->montoTotal = $ordenAtencion->montoTotal - $subTotal;
        $ordenAtencion->update();        
        $bitacora = bitacora::guardar('ordenAtencion','actualizar');

        $detalleOrden->delete();   
        $bitacora = bitacora::guardar('ordenAtencion','eliminar');

    }
    public function itemActualizar(Request $request){
         

        $detalle = detalleOrden::findOrFail($request->idDetalle);
        $detalle->cantidad = $request->cantidad;
        $detalle->subTotal =  ($request->cantidad*$request->precio);
        $detalle->update();

        $total = DB::table('detalleorden')
        ->select(DB::raw("sum(detalleorden.subTotal) as Total"))->where('idOrdenAtencion','=',$request->idOrdenAtencion)
        ->get();
        $bitacora = bitacora::guardar('detalleOrden','actualizar');


        $ordenAtencion = ordenAtencion::findOrFail($request->idOrdenAtencion);
        $ordenAtencion->montoTotal =  $total[0]->Total;
        $ordenAtencion->update();

        $bitacora = bitacora::guardar('ordenAtencion','actualizar');

        
    }
    public function agregarProductoDetalle(Request $request){


        
        $detalle = new detalleOrden();
        $detalle->cantidad = 1;
        $detalle->subTotal = $request->precio;
        $detalle->idOrdenAtencion = $request->idOrdenAtencion;
        $detalle->idProducto = $request->idProducto;
        $detalle->save();

        $bitacora = bitacora::guardar('detalleOrden','guardar');



        $total = DB::table('detalleorden')
        ->select(DB::raw("sum(detalleorden.subTotal) as Total"))->where('idOrdenAtencion','=',$request->idOrdenAtencion)
        ->get();

        $ordenAtencion = ordenAtencion::findOrFail($request->idOrdenAtencion);
        $ordenAtencion->montoTotal =  $total[0]->Total;
        $ordenAtencion->update();

        $bitacora = bitacora::guardar('ordenAtencion','actualizar');

    }
    public function finalizarOrden(Request $request){
        
        $mesa = mesa::findOrFail($request->idMesa);
        $mesa->ocupado = 0;
        $mesa->update();

        $bitacora = bitacora::guardar('mesa','actualizar');


        $ordenAtencion =  ordenAtencion::findOrFail($request->idOrdenAtencion);
        $ordenAtencion->estado = 0;
        $ordenAtencion->update();

        $bitacora = bitacora::guardar('ordenAtencion','actualizar');


    }
}
