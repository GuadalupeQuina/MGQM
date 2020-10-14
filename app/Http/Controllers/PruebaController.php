<?php

namespace App\Http\Controllers;

use App\bitacora;
use App\cliente;
use App\detalleOrden;
use App\mesa;
use App\ordenAtencion;
use App\repartidor;
use App\reserva;
use App\User;
use App\vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class PruebaController extends Controller
{
    public function prueba(){
        $nombre     = "Guadalupe";
        $apellidos  = "Rivero Quina";
        $login      = "Quina26";
        $email      = "guadalupequina@gmail.com";
        $password   = Hash::make( "MGQM26quina");

        $usuario = new User();
        $usuario->name      = $login;
        $usuario->email     = $email;
        $usuario->nombre    = $nombre;
        $usuario->apellidos = $apellidos;
        $usuario->password = $password; 
        $usuario->save();

        //$usuario->assignRole('cliente');
        $usuario->assignRole('administrador');
       
    }
    public function idUsuario(){
        return $this->rolUser();
    }

    public function clienteusuario(){
        
        $nombre     = "Gerardo";
        $apellidos  = "Arias Justiniano";
        $login      = "Gerardo99999";
        $email      = "gerardoarias@gmail.com";
        $password   = Hash::make( "23defebrero");
        // $password   = "23defebrero";

        $cliente = new cliente();
         
         $cliente->nombres   = $nombre;
         $cliente->apellidos = $apellidos;
         $cliente->login     = $login;
         $cliente->password  = $password;
         $cliente->empresa   = "FINOR";
         $cliente->telefono  = "5656735673";
         $cliente->direccion = "C/5 B/Urkupiña";
         $cliente->email     = $email;
         $cliente->estado    = 1;
         $cliente->save();

        $usuario = new User();
        $usuario->name      = $login;
        $usuario->email     = $email;
        $usuario->nombre    = $nombre;
        $usuario->apellidos = $apellidos;
        $usuario->password = $password; 
        $usuario->save();

        $usuario->assignRole('cliente');
        // $administrador->assignRole('administrador');


        // $rol = $usuario->roles()->implode('name',',');

        return [
            "usuario"=> $usuario , "role"=>$usuario->roles[0]->name
        ];


    }

    public function buscarId($email){
        $usuario = User::where('users.email',$email)->get();
        return $usuario[0]->id;
    }

    public function eliminarClienteUsuario(){
         $cliente= cliente::findOrFail(10);
         $cliente->delete();

         $idUser = $this->buscarId($cliente->email);
         $usuario = User::findOrFail($idUser);
         $usuario->delete();
        // Gerardo99999
    }
    public function repartidorUsuario(){
        
        $nombre     = "Carlos";
        $apellidos  = "Mendez Justiniano";
        $login      = "Carlo2344";
        $email      = "carlos123@gmail.com";
        $password   = Hash::make( "23defebrero");
        // $password   = "23defebrero";

         $repartidor = new repartidor();
         $repartidor->nombre   = $nombre;
         $repartidor->apellidos = $apellidos;
         $repartidor->login     = $login;
         $repartidor->password  = $password;
         $repartidor->telefono  = rand(60000000,79999999);
         $repartidor->direccion = "C/5 B/Urkupiña";
         $repartidor->email     = $email;
         $repartidor->cedulaID    = rand(5555555,9999999);
         $repartidor->save();

        $usuario = new User();
        $usuario->name      = $login;
        $usuario->email     = $email;
        $usuario->nombre    = $nombre;
        $usuario->apellidos = $apellidos;
        $usuario->password = $password; 
        $usuario->save();

        $usuario->assignRole('repartidor');
        // $administrador->assignRole('administrador');


        // $rol = $usuario->roles()->implode('name',',');

        return [
            "usuario"=> $usuario , "role"=>$usuario->roles[0]->name
        ];


    }
    public function reserva(){

        $cliente= 4;

        $reserva = new reserva();
        $reserva->comensales = 5;
        $reserva->telefono = "778787878";
        $reserva->fecha = "2020-09-23";
        $reserva->hora= '15:10:00';
        $reserva->observacion = "ninguna";
        $reserva->idCliente = $cliente;
        $reserva->save();
        return $reserva;
    }
    public function mesas(){
        $cantidad = 10;
        for ($i=0; $i < $cantidad; $i++) { 
            $mesa = new mesa();
            $mesa->descripcion = "sin descripcion";
            $mesa->ocupado = 0;
            $mesa->capacidad = rand(1,6);
            $mesa->ubicacion = "$i-A";
            $mesa->save();
        }
        return mesa::all();
    }

    public function vehiculo(){
        // Revisar que el id exista antes de colocarlo
        $repartidor = 1;

        $vehiculo = new vehiculo();
        $vehiculo->tipoVehiculo = "moto";
        $vehiculo->caracteristicas = "roja deportiva";
        $vehiculo->placa = "BHJK-345";
        $vehiculo->idRepartidor = $repartidor;
        $vehiculo->save();


        return $vehiculo;

    }
    public function rolUser(){
        return Role::all();
    }


    public function usuarios(){
        // $usuario ;
        return ;
    }

    public function UserRol($id){
        
        // $usuario=User::all();
        // $user = $usuario[0]->id;



    
        $us = User::findOrFail($id);
        $us->roles;
        // $usuario->roles;
        return [ "user"=>$us];

    }

    public function insertarUsuario(){


            
            
            $nombres    = ["Gerardo","Miguel","Eldy"];
            $apellidos  = ["Arias Justiniano","Ortega Sanchez","Maldonado Cuellar"];
            $logins     = ["gerardo99777","miguel9999","eldy233"];
            $emails     = ["gerardoarias23@gmail.com","miguel09@gmail.com","eldymacu23@gmail.com"];
            $password   = Hash::make( "23defebrero");
            $roles   = ["administrador","repartidor","cliente"];          
            $length = count($nombres);
            $telefonos = ["776873687","78797987","65256521"];
            $direcciones = ["C/5 B/Urkupiña","C/Bolivar","C/7 Villa Cochbamba"];

            for ($i=0; $i < $length; $i++) { 


                $usuario = new User();
                $usuario->name      = $logins[$i];
                $usuario->email     = $emails[$i];
                $usuario->nombre    = $nombres[$i];
                $usuario->apellidos = $apellidos[$i];
                $usuario->password  = $password; 
                $usuario->save();
    
    
                if($roles[$i]=="cliente"){
                    $cliente = new cliente();
                    $cliente->id = $usuario->id;
                    $cliente->nombres   = $nombres[$i];
                    $cliente->apellidos = $apellidos[$i];
                    $cliente->login     = $logins[$i];
                    $cliente->password  = Hash::make($password);
                    $cliente->empresa   = "FINOR";
                    $cliente->telefono  = $telefonos[$i];
                    $cliente->direccion = $direcciones[$i];
                    $cliente->email     = $emails[$i];
                    $cliente->estado    = 0;
                    $cliente->save();
                }
                if($roles[$i]=="repartidor"){
                    $repartidor = new repartidor();
                    $repartidor->id = $usuario->id;

                    $repartidor->nombre = $nombres[$i];
                    $repartidor->apellidos = $apellidos[$i];
                    $repartidor->login = $logins[$i];
                    $repartidor->password = Hash::make($password);
                    $repartidor->cedulaID = "76769989";
                    $repartidor->email = $emails[$i];
                    $repartidor->telefono = $telefonos[$i];
                    $repartidor->direccion = $direcciones[$i];
                    $repartidor->save();
                }

                $usuario->assignRole($roles[$i]);
    
            }
            
        //     DB::commit();
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        // }
        
        return [ "Usuarios"=>User::all()
            // "usuario"=> $usuario , "role"=>$usuario->roles[0]->name
        ];
    }


    public function usuarioPrueba(){
        $id = 4;
        $nombres = "Hugo";
        $apellidos = "Burgos";
        $login = "Hugo55545";
        $password = "23defebrero";
        $empresa = "empresa";
        $telefono="76666443";
        $direccion ="";
        $email ="hogo887876@gmail.com";
        $estado = 0;


            $cliente= cliente::findOrFail($id);
            $cliente->nombres = $nombres;
            $cliente->apellidos = $apellidos;
            $cliente->login = $login;
             if($password!=""){
                $cliente->password = $password;
             }
            $cliente->empresa = $empresa;
            $cliente->telefono = $telefono;
            $cliente->direccion = $direccion;
            $cliente->email = $email;
            $cliente->estado = $estado;
            $cliente->update();

            $users = User::where('users.email','=',$email)->get();
            $existe= count($users);
            
            if($existe){
                $idUser = $this->buscarId($cliente->email);
                $usuario = User::findOrFail($idUser);
                $usuario->name      = $login;
                $usuario->email     = $email;
                $usuario->nombre    = $nombres;
                $usuario->apellidos = $apellidos;
                $usuario->password =  $password; 
                $usuario->update();

                $cliente->estado = 1;
                $cliente->update();
                
            }else{
                
                if($login != "" && $password != "" && $email != ""){
                    $usuario = new User();
                    $usuario->name      = $login;
                    $usuario->email     = $email;
                    $usuario->nombre    = $nombres;
                    $usuario->apellidos = $apellidos;
                    $usuario->password = $password; 
                    $usuario->save();
            
                    $usuario->assignRole('cliente');

                    $cliente->estado = 1;
                    $cliente->update();
                    return "se ha registrado como un nuevo usuario";


                }
            }



            // if($this->existeUser($email)){
            //     return $this->
                // return "existe el email".$email;

                // $idUser = $this->buscarId($cliente->email);
                // $usuario = User::findOrFail($idUser);
                // $usuario->name      = $login;
                // $usuario->email     = $email;
                // $usuario->nombre    = $nombres;
                // $usuario->apellidos = $apellidos;
                // $usuario->password = Hash::make( $password); 
                // $usuario->update();

                // $cliente->estado = 1;
                // $cliente->update();

            // }else{
                
                // return "no existe el email".$email;
                // if($login != "" && $password != "" && $email != ""){
                                            
                //     $usuario = new User();
                //     $usuario->name      = $login;
                //     $usuario->email     = $email;
                //     $usuario->nombre    = $nombres;
                //     $usuario->apellidos = $apellidos;
                //     $usuario->password = Hash::make( $password); 
                //     $usuario->save();
            
                //     $usuario->assignRole('cliente');

                //     $cliente->estado = 1;
                //     $cliente->update();
                // }

            
    }

    public function existeUser($email){
        // $existe = false ;

    return   $users = User::where('users.email','=',$email)->get();

        // if($users){
        //     $existe = true;
        // }
        // return $existe;
    }
}
 
