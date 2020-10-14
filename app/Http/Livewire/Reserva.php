<?php

namespace App\Http\Livewire;
use App\bitacora;
use App\reserva as AppReserva;
use Livewire\Component;
use Livewire\WithPagination;

class Reserva extends Component{

    public $searchText;
    public $usuario_id;
    public $formulario = 0;
    public $comensales;
    public $fecha;
    public $hora;
    public $observacion;
    public $telefono;
    public $reserva_id ;
    public $actualizar = 0;

    use WithPagination;

    public function render(){

        $searchText = '%'.$this->searchText.'%';
        return view('livewire.reserva',[
            'reservas' => AppReserva::where('comensales','LIKE','%'.$searchText.'%')
            ->orWhere('hora','LIKE','%'.$searchText.'%')
            ->orWhere('fecha','LIKE','%'.$searchText.'%')
            ->paginate(3)
        ]);
    }

    public function userAuth($id){
        $this->usuario_id =  $id;
    }

    public function mostrarReservaFormulario(){
        $this->formulario = 1;
    }


    public function guardarReserva($idCliente){
        
        $reserva              = new AppReserva();
        $reserva->comensales  = $this->comensales;
        $reserva->telefono    = $this->telefono;
        $reserva->fecha       = $this->fecha;
        $reserva->hora        = $this->hora;
        $reserva->observacion = $this->observacion;   
        $reserva->idCliente   = $idCliente;
        $reserva->save();
        $bitacora = bitacora::guardar('reserva','guardar');

        $this->formulario = 0;
    }
    
    public function cancelarReserva(){
        $this->formulario = 0;
        $this->actualizar = 0;
        $this->resetearVariable();
    }

    public function resetearVariable(){
            $this->comensales=0;
            $this->telefono=0;
            $this->fecha='';
            $this->hora='';
            $this->observacion='';
    }
    public function mostrarFormularioguardar(){
        $this->resetearVariable();
        $this->mostrarReservaFormulario();
    }

    public function mostrarFormularioActualizar($reserva_id){

        $reserva           = AppReserva::findOrFail($reserva_id);
        $this->comensales  = $reserva->comensales;
        $this->fecha       = $reserva->fecha;
        $this->hora        = $reserva->hora;
        $this->observacion = $reserva->observacion;
        $this->telefono = $reserva->telefono;
        $this->reserva_id  = $reserva_id; 

        $this->formulario = 1;
        $this->actualizar = 1;

        $bitacora = bitacora::guardar('reserva','actualizar');
    }
    public function actualizarReserva($usuario_id){
        $reserva_id = $this->reserva_id;
        $reserva    = AppReserva::findOrFail($reserva_id);

        $reserva->comensales   =  $this->comensales  ;
        $reserva->fecha        =  $this->fecha       ;
        $reserva->hora         =  $this->hora        ;
        $reserva->observacion  =  $this->observacion ;
        $reserva->telefono     =  $this->telefono    ;
        $reserva->idCliente    =  $usuario_id    ;
        $reserva->update();

        
        $this->formulario = 0;
        $this->actualizar = 0;

    }

    public function eliminarReserva( $reserva_id ){
        $reserva = AppReserva::findOrFail($reserva_id);
        $reserva->delete();
        $bitacora = bitacora::guardar('reserva','eliminar');

    }
}
