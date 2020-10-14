<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Contenedor extends Component
{
    public $opcion = 0;
    public function render()
    {
        return view('livewire.contenedor');
    }

    public function contenido($opcion){
        if($opcion==0){
            $this->opcion = $opcion;
        }
        if($opcion==1){
            $this->opcion = $opcion;
        }
        if($opcion==2){
            $this->opcion = $opcion;
        }
        if($opcion==3){
            $this->opcion = $opcion;
        }
        if($opcion==4){
            $this->opcion = $opcion;
            
        }
        if($opcion==5){
            $this->opcion = $opcion;
        }
        if($opcion==6){
            $this->opcion = $opcion;
        }
    }
}
