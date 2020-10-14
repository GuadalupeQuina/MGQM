<?php

namespace App\Http\Controllers;

use App\bitacora;
use App\repartidor;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ctrlRepartidor extends Controller{

    public function index(Request $request){
        //  if(!$request->ajax()) return redirect('/');
         
         $buscar = $request->buscar;
         $criterio = $request->criterio;
         if($buscar==''){
             $repartidor= repartidor::select('repartidor.id','repartidor.nombre',
             'repartidor.apellidos',
             'repartidor.login',
             'repartidor.password',
             'repartidor.cedulaID',
             'repartidor.telefono',
             'repartidor.email',
             'repartidor.direccion')
             ->orderBy('repartidor.id','desc')->paginate(10);
         }
         else{
             $repartidor= repartidor::select('repartidor.id','repartidor.nombre',
             'repartidor.apellidos',
             'repartidor.login',
             'repartidor.password',
             'repartidor.cedulaID',
             'repartidor.telefono',
             'repartidor.email',
             'repartidor.direccion')
             ->where('repartidor.'.$criterio, 'like', '%'.$buscar.'%')
             ->orderBy('repartidor.id','desc')->paginate(10);            
         }
         
         return [
             'pagination' => [
                 'total'        => $repartidor->total(),
                 'current_page' => $repartidor->currentPage(),
                 'per_page'     => $repartidor->perPage(),
                 'last_page'    => $repartidor->lastPage(),
                 'from'         => $repartidor->firstItem(),
                 'to'           => $repartidor->lastItem(),
             ],
             'repartidor' => $repartidor
         ];
    }

    public function store(Request $request){        
        

            $usuario = new User();
            $usuario->name      = $request->login;
            $usuario->email     = $request->email;
            $usuario->nombre    = $request->nombre;
            $usuario->apellidos = $request->apellidos;
            $usuario->password  = Hash::make( $request->password); 
            $usuario->save();


            $repartidor             = new repartidor();
            $repartidor->id         = $usuario->id;
            $repartidor->nombre     = $request->nombre;
            $repartidor->apellidos  = $request->apellidos;
            $repartidor->login      = $request->login;
            $repartidor->password   = Hash::make( $request->password);
            $repartidor->cedulaID   = $request->cedulaID;
            $repartidor->email      = $request->email;
            $repartidor->telefono   = $request->telefono;
            $repartidor->direccion  = $request->direccion;
            $repartidor->save();
   

            $usuario->assignRole('repartidor');

            $bitacora = bitacora::guardar('repartidor','guardar');
            $bitacora = bitacora::guardar('usuario','guardar-repartidor');

    }

    public function update(Request $request){

        //  if(!$request->ajax()) return redirect('/');


            
            $usuario            = User::findOrFail($request->id);
            $usuario->name      = $request->login;
            $usuario->email     = $request->email;
            $usuario->nombre    = $request->nombre;
            $usuario->apellidos = $request->apellidos;
            if($request->password!=""){
                $usuario->password =Hash::make( $request->password);
            }
            $usuario->update();

            $repartidor= repartidor::findOrFail($request->id);
            $repartidor->nombre     = $request->nombre;
            $repartidor->apellidos  = $request->apellidos;
            $repartidor->login      = $request->login;

            if($request->password!=""){
            $repartidor->password =Hash::make( $request->password);
            }
            $repartidor->cedulaID  = $request->cedulaID;
            $repartidor->telefono  = $request->telefono;
            $repartidor->direccion = $request->direccion;
            $repartidor->update();


            $bitacora = bitacora::guardar('repartidor','actualizar');
            $bitacora = bitacora::guardar('usuario','actualizar-repartidor');

    }

    public function delete(Request $request){

         $repartidor= repartidor::findOrFail($request->id);
         $repartidor->delete();

         $idUser = $this->buscarId($repartidor->email);

         $usuario = User::findOrFail($idUser);
         $usuario->delete();

         $bitacora = bitacora::guardar('repartidor','eliminar');
         $bitacora = bitacora::guardar('usuario','eliminar-repartidor');
    }

    public function selectRepartidor(){
         $repartidor = repartidor::select('id','nombre')->orderBy('nombre', 'asc')->get();
         return ['repartidor' => $repartidor];
    }
    
    public function buscarId($email){
        $usuario = User::where('users.email',$email)->get();
        return $usuario[0]->id;
    }     
}
