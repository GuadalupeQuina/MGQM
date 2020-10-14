<?php

namespace App\Http\Controllers;

use App\bitacora;
use Illuminate\Http\Request;
use App\vehiculo;
use App\repartidor;
use Illuminate\Support\Facades\DB;

class ctrlVehiculo extends Controller
{
    public function mostrar(Request $request){
        
        if (!$request->ajax()) return redirect('/indes');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $atributo1= '';
        $atributo2= '';
        if($criterio=="vehiculo"){
            $atributo1 = 'tipoVehiculo';
            $atributo2 = 'placa';
        }else{
            $atributo1 ="nombre";
            $atributo2 ="apellidos";
        }

        if ($buscar==''){
            $vehiculo = vehiculo::join('repartidor','vehiculo.idRepartidor','=','repartidor.id')
            ->select('vehiculo.id',
                     'vehiculo.idRepartidor',
                     'vehiculo.tipoVehiculo',
                     'vehiculo.caracteristicas',
                     'vehiculo.placa',
                     DB::raw('CONCAT(nombre, " ", apellidos) as repartidor',
                     'repartidor.nombre',
                     'repartidor.apellidos'
                     )
                     )
            ->orderBy('vehiculo.id', 'desc')->paginate(10);
        }
        else{
            
            $vehiculo = vehiculo::join('repartidor','vehiculo.idRepartidor','=','repartidor.id')
            ->select('vehiculo.id',
                        'vehiculo.idRepartidor',
                        'vehiculo.tipoVehiculo',
                        'vehiculo.caracteristicas',
                        'vehiculo.placa',
                        DB::raw('CONCAT(nombre, " ", apellidos) as repartidor',
                        'repartidor.nombre',
                        'repartidor.apellidos'
                        )
                        )
            ->where($criterio.'.'.$atributo1, 'like', '%'. $buscar . '%')
            ->orWhere($criterio.'.'.$atributo2, 'like', '%'. $buscar . '%')
            ->orderBy('vehiculo.id', 'desc')->paginate(10);
        }
        

        return [
            'pagination' => [
                'total'        => $vehiculo->total(),
                'current_page' => $vehiculo->currentPage(),
                'per_page'     => $vehiculo->perPage(),
                'last_page'    => $vehiculo->lastPage(),
                'from'         => $vehiculo->firstItem(),
                'to'           => $vehiculo->lastItem(),
            ],
            'vehiculo' => $vehiculo
        ];
    }
    public function guardar(Request $request){
       
        $vehiculo = new vehiculo();
     
        $vehiculo->tipoVehiculo = $request->tipoVehiculo;
        $vehiculo->caracteristicas = $request->caracteristicas;
        $vehiculo->placa = $request->placa;
        $vehiculo->idRepartidor = $request->idRepartidor;
        $vehiculo->save();

        $bitacora = bitacora::guardar('vehiculo','guardar');
    }
    public function modificar(Request $request){
        if (!$request->ajax()) return redirect('/index');
        $vehiculo = vehiculo::findOrFail($request->id);
        $vehiculo->idRepartidor = $request->idRepartidor;
        $vehiculo->tipoVehiculo = $request->tipoVehiculo;
        $vehiculo->caracteristicas = $request->caracteristicas;
        $vehiculo->placa = $request->placa;
        $vehiculo->save();
        $bitacora = bitacora::guardar('vehiculo','actualizar');

    }
    public function eliminar(Request $request){
        if (!$request->ajax()) return redirect('/index');
        $vehiculo = vehiculo::findOrFail($request->id);
        $vehiculo->delete();
        return ['vehiculo' => $vehiculo];
        $bitacora = bitacora::guardar('vehiculo','eliminar');

    }   
}