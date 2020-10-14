<?php

namespace App\Http\Controllers;

use App\bitacora;
use App\cliente;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ctrlCliente extends Controller
{
    public function index(Request $request){

        if(!$request->ajax()) return redirect('/index');
        
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
             $cliente= cliente::select('cliente.id',
             'cliente.nombres',
             'cliente.apellidos',
             DB::raw('CONCAT(nombres," ",apellidos) as nombreCompleto'),
             'cliente.login',
             'cliente.password',
             'cliente.empresa',
             'cliente.telefono',
             'cliente.direccion',
             'cliente.email',
             'cliente.estado'
             )
             ->orderBy('cliente.id','desc')


            //  "usuario"=> $usuario , "role"=>$usuario->roles[0]->name
             ->paginate(10);
         }
         else{
             $cliente= cliente::select('cliente.id','cliente.nombres',
             'cliente.apellidos',
             DB::raw('CONCAT(nombres," ",apellidos) as nombreCompleto'),
             'cliente.login',

             'cliente.password',
             'cliente.empresa',
             'cliente.telefono',
             'cliente.direccion',
             'cliente.email',
             'cliente.estado')
             ->where('cliente.'.$criterio, 'like', '%'.$buscar.'%')
             ->orderBy('cliente.id','desc')->paginate(10);            
         }


         
         return [
             'pagination' => [
                 'total'        => $cliente->total(),
                 'current_page' => $cliente->currentPage(),
                 'per_page'     => $cliente->perPage(),
                 'last_page'    => $cliente->lastPage(),
                 'from'         => $cliente->firstItem(),
                 'to'           => $cliente->lastItem(),
             ],
             'cliente' => $cliente
            ];
    }

    public function store(Request $request){        
           
            try {
                    DB::beginTransaction();
                                            
                        $usuario = new User();
                        $usuario->name      = $request->login;
                        $usuario->email     = $request->email;
                        $usuario->nombre    = $request->nombres;
                        $usuario->apellidos = $request->apellidos;
                        $usuario->password  = Hash::make( $request->password); 
                        $usuario->save();

                        $cliente = new cliente();           
                        $cliente->id = $usuario->id;

                        $cliente->nombres   = $request->nombres;
                        $cliente->apellidos = $request->apellidos;
                        $cliente->login     = $request->login;
                        $cliente->password  = Hash::make( $request->password);
                        $cliente->empresa   = $request->empresa;
                        $cliente->telefono  = $request->telefono;
                        $cliente->direccion = $request->direccion;
                        $cliente->email     = $request->email;
                        $cliente->estado    = 0;
                        $cliente->save();
                
                        $usuario->assignRole('cliente');

                        $bitacora = bitacora::guardar('cliente','guardar');

                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollBack();
            }    
    }

    public function datoUser(Request $request){
        $usuario = cliente::where('cliente.email',$request->email)->get();
        return ['dato' => $usuario];
    }

    public function update(Request $request){
         

        if(!$request->ajax()) return redirect('/index');         
        try {
             DB::beginTransaction();
        
                $cliente= cliente::findOrFail($request->id);
                $cliente->nombres = $request->nombres;
                $cliente->apellidos = $request->apellidos;
                $cliente->login = $request->login;
                if($request->password!=""){
                    $cliente->password = Hash::make($request->password);
                }
                $cliente->empresa = $request->empresa;
                $cliente->telefono = $request->telefono;
                $cliente->direccion = $request->direccion;
                $cliente->email = $request->email;
                $cliente->estado = 0;

                $cliente->update();

                

                $usuario = User::findOrFail($cliente->id);
                $usuario->name      = $request->login;
                $usuario->email     = $request->email;
                $usuario->nombre    = $request->nombres;
                $usuario->apellidos = $request->apellidos;
                $usuario->password =  Hash::make($request->password); 
                $usuario->update();
                
                $bitacora = bitacora::guardar('cliente','actuaizar');
                $bitacora = bitacora::guardar('usuario','actuaizar-cliente');

            DB::commit();
        } catch (\Throwable $th) {
             DB::rollback();
        }
    }

    public function delete(Request $request){

        $cliente= cliente::findOrFail($request->id);
        $cliente->delete();

        $usuario = User::findOrFail($request->id);
        $usuario->delete();

        $bitacora = bitacora::guardar('cliente','eliminar');

    }

    public function desactivar(Request $request){
         $cliente= cliente::findOrFail($request->id);
         $cliente->estado = 0;
         $cliente->update();

    }

    public function activar(Request $request){
        $cliente= cliente::findOrFail($request->id);
        $cliente->estado = 1;
        $cliente->update();
    }

    public function selectCliente(Request $request){
        
            // if (!$request->ajax()) return redirect('/');
    
            $filtro = $request->filtro;
            $clientes = cliente::select(DB::raw('CONCAT(nombres, " ", apellidos) as nombreCompleto'),'id','empresa')->where('cliente.nombres', 'like', '%'. $filtro . '%')
            ->orderBy('cliente.nombres', 'asc')->get();
    
            return ['clientes' => $clientes];
    }
}
