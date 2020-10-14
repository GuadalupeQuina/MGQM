<?php

namespace App\Http\Controllers;

use App\bitacora;
use Illuminate\Http\Request;
use App\reserva;
use App\cliente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ctrlReserva extends Controller
{
    public function mostrar(Request $request){
        
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->get('buscar');
        $criterio = $request->criterio;
           
        
        if($buscar==""){
            $reserva = reserva::join('cliente','reserva.idCliente','=','cliente.id')->select(
                "reserva.id",
                "reserva.comensales",
                "reserva.telefono",
                "reserva.fecha",
                "reserva.hora",
                "reserva.observacion",
                "reserva.idCliente",
                "cliente.nombres",
                "cliente.apellidos",
                DB::raw('CONCAT(nombres, " ",apellidos)as nombreCompleto')
            )
            ->orderBy('reserva.id','desc')
            ->paginate(10);
        }else{
            $reserva = reserva::join('cliente','reserva.idCliente','=','cliente.id')->select(
                "reserva.id",
                "reserva.comensales",
                "reserva.telefono",
                "reserva.fecha",
                "reserva.hora",
                "reserva.observacion",
                "idCliente",
                "cliente.nombres",
                "cliente.apellidos",
                DB::raw('CONCAT(nombres, " ",apellidos)as nombreCompleto')
            )
            ->orderBy('reserva.id','desc')
            ->where($criterio.'.nombres', 'like', '%'.$buscar.'%')
            ->paginate(10);
        }

    

      

        

        return [

            'pagination' => [
                'total'        => $reserva->total(),
                'current_page' => $reserva->currentPage(),
                'per_page'     => $reserva->perPage(),
                'last_page'    => $reserva->lastPage(),
                'from'         => $reserva->firstItem(),
                'to'           => $reserva->lastItem(),
            ],
            'reserva' => $reserva,
        ];
    }

    
    public function guardar(Request $request){
        // if (!$request->ajax()) return redirect('/');
        $reserva = new reserva();
       
        $reserva->comensales = $request->comensales;
        $reserva->telefono = $request->telefono;
        $reserva->fecha = $request->fecha;
        $reserva->hora = $request->hora;
        $reserva->observacion = $request->observacion;
        $reserva->idCliente = $request->idCliente;
        $reserva->save();

        $bitacora = bitacora::guardar('reserva','guardar');
    }



    public function modificar(Request $request){
        // if (!$request->ajax()) return redirect('/');

        $reserva = reserva::findOrFail($request->id);
        $reserva->comensales = $request->comensales;
        $reserva->telefono = $request->telefono;
        $reserva->fecha = $request->fecha;
        $reserva->hora = $request->hora;
        $reserva->observacion = $request->observacion;
        $reserva->idCliente = $request->idCliente;
        $reserva->update();

        $bitacora = bitacora::guardar('reserva','actualizar');
    }





    public function eliminar(Request $request){
        // if (!$request->ajax()) return redirect('/');
        $reserva = reserva::findOrFail($request->id);
        $reserva->delete();

        $bitacora = bitacora::guardar('reserva','eliminar');

        return ['reserva' => $reserva];
    }


    
    public function mostrarReservaCliente(Request $request){
        
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->get('buscar');
        $criterio = $request->criterio;
        $idCliente = Auth::id();
           
        
        if($buscar==""){
            $reserva = reserva::join('cliente','reserva.idCliente','=','cliente.id')->select(
                "reserva.id",
                "reserva.comensales",
                "reserva.telefono",
                "reserva.fecha",
                "reserva.hora",
                "reserva.observacion",
                "reserva.idCliente"
            )
            ->orderBy('reserva.id','desc')
            ->where('idCliente','=',$idCliente)
            ->paginate(10);
        }else{
            $reserva = reserva::join('cliente','reserva.idCliente','=','cliente.id')->select(
                "reserva.id",
                "reserva.comensales",
                "reserva.telefono",
                "reserva.fecha",
                "reserva.hora",
                "reserva.observacion",
                "idCliente"
            )
            ->orderBy('reserva.id','desc')
            ->where('reserva.'.$criterio, '=',$buscar)
            ->where('idCliente','=',$idCliente)
            ->paginate(10);
        }

    

      

        

        return [

            'pagination' => [
                'total'        => $reserva->total(),
                'current_page' => $reserva->currentPage(),
                'per_page'     => $reserva->perPage(),
                'last_page'    => $reserva->lastPage(),
                'from'         => $reserva->firstItem(),
                'to'           => $reserva->lastItem(),
            ],
            'reserva' => $reserva,
        ];
    }
    public function modificarReservaCliente(Request $request){

        $idCliente              = Auth::id();
        $reserva                = reserva::findOrFail($request->id);
        $reserva->comensales    = $request->comensales;
        $reserva->telefono      = $request->telefono;
        $reserva->fecha         = $request->fecha;
        $reserva->hora          = $request->hora;
        $reserva->observacion   = $request->observacion;
        $reserva->idCliente     = $idCliente;
        $reserva->update();

        $bitacora = bitacora::guardar('reserva','actualizar');
    }
    public function guardarReservaCliente(Request $request){
        
        $idCliente = Auth::id();

        $reserva                = new reserva();
        $reserva->comensales    = $request->comensales;
        $reserva->telefono      = $request->telefono;
        $reserva->fecha         = $request->fecha;
        $reserva->hora          = $request->hora;
        $reserva->observacion   = $request->observacion;
        $reserva->idCliente     = $idCliente;
        $reserva->save();

        $bitacora = bitacora::guardar('reserva','guardar');
    }
}
