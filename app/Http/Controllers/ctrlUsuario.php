<?php

namespace App\Http\Controllers;

use App\bitacora;
use App\cliente;
use App\repartidor;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ctrlUsuario extends Controller{
    
    public function index(Request $request){
        //if(!$request->ajax()) return redirect('/');




        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){

            // $users = User::with('roles')->get();                
            // return ['users' => $users];
            $usuario= User::select('id',
            'users.nombre',
            'users.apellidos',
            DB::raw('CONCAT(nombre," ",apellidos) as nombreCompleto'),
            'users.name',
            'users.email',
            'users.password'
            )->with('roles')
            ->orderBy('users.id','desc')
            ->paginate(2);
        }else{
            $usuario= User::select('id',
            'users.nombre',
            'users.apellidos',
            DB::raw('CONCAT(nombre," ",apellidos) as nombreCompleto'),
            'users.name',
            'users.email',
            'users.password'
            )->with('roles')
            ->orderBy('users.id','desc')
            ->where('users.'.$criterio,'LIKE','%'.$buscar.'%')
            ->paginate(2);
        }
        return [
            'pagination' => [
                'total'        => $usuario->total(),
                'current_page' => $usuario->currentPage(),
                'per_page'     => $usuario->perPage(),
                'last_page'    => $usuario->lastPage(),
                'from'         => $usuario->firstItem(),
                'to'           => $usuario->lastItem(),
            ],
            'usuario' => $usuario,
            // 'rol'=> $arrayRole
           ];
            // 'usuario' => $usuario[0]->roles[0]["name"],
            // 'rol'=> $arrayRole
    }
    public function obtenerRol(int $id){
        
        $rol = User::findOrFail($id);
        $rol->roles;
        return [ "rol"=>$rol];
    }
    public function guardar(Request $request){
        try {
            DB::beginTransaction();

                if($request->rol=="administrador"){
                    $usuario = new User();
                    $usuario->name      = $request->name;
                    $usuario->email     = $request->email;
                    $usuario->nombre    = $request->nombre;
                    $usuario->apellidos = $request->apellidos;
                    $usuario->password  = Hash::make($request->password);
                    $usuario->save();
                    $usuario->assignRole($request->rol);
                    $bitacora = bitacora::guardar('usuario','guardar-administrador');
                }
                if($request->rol=="cliente"){
        

        
                    $usuario = new User();
                    $usuario->name      = $request->name;
                    $usuario->email     = $request->email;
                    $usuario->nombre    = $request->nombre;
                    $usuario->apellidos = $request->apellidos;
                    $usuario->password = Hash::make( $request->password); 
                    $usuario->save();
                    $usuario->assignRole('cliente');

                    $cliente            = new cliente();
                    $cliente->id        = $usuario->id;
                    $cliente->nombres   = $request->nombre;
                    $cliente->apellidos = $request->apellidos;
                    $cliente->login     = $request->name;
                    $cliente->password  = Hash::make( $request->password);
                    $cliente->empresa   = $request->empresa;
                    $cliente->telefono  = $request->telefono;
                    $cliente->direccion = $request->direccion;
                    $cliente->email     = $request->email;
                    $cliente->estado    = 0;
                    $cliente->save();

                    $bitacora = bitacora::guardar('usuario','guardar-cliente');
                    $bitacora = bitacora::guardar('cliente','guardar');

                }
                if($request->rol=="repartidor"){
                    
        
                    $usuario = new User();
                    $usuario->name      = $request->name;
                    $usuario->email     = $request->email;
                    $usuario->nombre    = $request->nombre;
                    $usuario->apellidos = $request->apellidos;
                    $usuario->password  = Hash::make( $request->password); 
                    $usuario->save();


                    $repartidor             = new repartidor();
                    $repartidor->id         = $usuario->id;
                    $repartidor->nombre     = $request->nombre;
                    $repartidor->apellidos  = $request->apellidos;
                    $repartidor->login      = $request->name;
                    $repartidor->password   = Hash::make( $request->password);
                    $repartidor->cedulaID   = $request->cedulaID;
                    $repartidor->email      = $request->email;
                    $repartidor->telefono   = $request->telefono;
                    $repartidor->direccion  = $request->direccion;
                    $repartidor->save();

                    $usuario->assignRole('repartidor');
                    $bitacora = bitacora::guardar('usuario','guardar-repartidor');
                    $bitacora = bitacora::guardar('repartidor','guardar');


                }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }


    }
    public function autenticado(){
        
        $usuario = Auth::id(); 
        $rol = User::findOrFail($usuario);
        $rol->roles;


        return [
            "rol" => $rol,
            "autenticado" => Auth::user(),
            "idUser" => $usuario
        ];
    }    
}
