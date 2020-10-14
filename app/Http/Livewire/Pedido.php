<?php

namespace App\Http\Livewire;

use App\pedido as AppPedido;
use Livewire\Component;

class Pedido extends Component
{
    public $formulario = 0;

    public function render()
    {
        return view('livewire.pedido',[
            
        ]);
    }
}

// $table->date('fecha');
// $table->date('fechaentrega');
// $table->time('horaentrega');
// $table->string('glosa');
// $table->float('montototal');
// $table->boolean('estado');

// $table->integer('idUsuario')->unsigned();
// $table->integer('idCliente')->unsigned();
// $table->integer('idRepartidor')->unsigned()->nullable();
// $table->integer('idUbicaion')->unsigned()->nullable();
