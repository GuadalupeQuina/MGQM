<?php

namespace App\Http\Livewire;

use App\repartidor as AppRepartidor;
use App\vehiculo;
use Livewire\Component;
use Livewire\WithPagination;

class Repartidor extends Component
{
    public $searchText ;
    use WithPagination;
    public function render()
    {
        $searchText = '%'.$this->searchText.'%';
        return view('livewire.repartidor',[
            'repartidores'=> vehiculo::join('repartidor','repartidor.id','=','vehiculo.idRepartidor')
            ->select(
                'repartidor.nombre',
                'repartidor.apellidos',
                'repartidor.login',
                'repartidor.password',
                'repartidor.cedulaID',
                'repartidor.telefono',
                'repartidor.direccion',
                'vehiculo.tipoVehiculo',
                'vehiculo.caracteristicas',
                'vehiculo.placa',
                'vehiculo.idRepartidor'
            )
            ->where('nombre','LIKE','%'.$searchText.'%')
            ->orWhere('cedulaID','LIKE','%'.$searchText.'%')
            ->orWhere('apellidos','LIKE','%'.$searchText.'%')
            ->paginate(10)
        ]);
    }
}