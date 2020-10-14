<?php

namespace App\Http\Livewire;

use App\bitacora;
use App\cliente;
use App\reserva;
use App\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Reservaciones extends Component
{
    //Usuario autenticado
    public $usuario_id;
    public $name;
    public $email;
    public $password;

    public $siguiente=0;
   
    // mensaje despues de reservar
    public $messageReservacion = 0;
    
    public $formulario = 0;

    public $comensales;
    public $fecha;
    public $hora;
    public $observacion;

    public $cliente_id;
    public $nombres;
    public $apellidos;
    public $empresa;
    public $telefono;
    public $direccion;

    
    public function render()
    {
        return view('livewire.reservaciones');
    }

    public function mostrarFormularioReservacion(){
        $this->formulario = 1;
    }
    public function guardarReservacionAuth($usuario_id){

        $reserva = new reserva();
        $reserva->comensales  = $this->comensales;
        $reserva->fecha       = $this->fecha;
        $reserva->hora        = $this->hora;
        $reserva->telefono    = $this->telefono;
        $reserva->observacion = $this->observacion;
        $reserva->idCliente   = $usuario_id;
        $reserva->save();

        $this->siguiente++;

        $bitacora = bitacora::guardar('reserva','guardar'); 
    }

    public function siguientePaso(){
        $this->siguiente++;
    }
    public function anteriorPaso(){
        $this->siguiente--;
    }

    public function guardarReservacionLogout(){

        $usuario = new User();
        $usuario->name      = $this->name;
        $usuario->email     = $this->email;
        $usuario->nombre    = $this->nombres;
        $usuario->apellidos = $this->apellidos;
        $usuario->password  = Hash::make( $this->password); 
        $usuario->save();

        $cliente            = new cliente();           
        $cliente->id        = $usuario->id;
        $cliente->nombres   = $this->nombres;
        $cliente->apellidos = $this->apellidos;
        $cliente->login     = $this->name;
        $cliente->password  = Hash::make( $this->password);
        $cliente->empresa   = $this->empresa;
        $cliente->telefono  = $this->telefono;
        $cliente->direccion = $this->direccion;
        $cliente->email     = $this->email;
        $cliente->estado    = 1;
        $cliente->save();

        $reserva              = new reserva();
        $reserva->comensales  = $this->comensales;
        $reserva->telefono    = $this->telefono;
        $reserva->fecha       = $this->fecha;
        $reserva->hora        = $this->hora;
        $reserva->observacion = $this->observacion;
        $reserva->idCliente   = $cliente->id;
        $reserva->save();

        $usuario->assignRole('cliente');
        $this->siguientePaso();

        
    }

    public function resetearVariables(){

         $this->name='';
         $this->email='';
         $this->nombres='';
         $this->apellidos='';
         $this->password='';
         $this->empresa='';
         $this->telefono=0;
         $this->direccion='';
         $this->comensales=0;
         $this->telefono=0;
         $this->fecha='';
         $this->hora='';
         $this->observacion='';

    }
    public function finalizarReserva(){
        $this->siguiente=0;
        $this->formulario=0;
    }

    

    
}
