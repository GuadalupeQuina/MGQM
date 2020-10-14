<?php

namespace App\Http\Livewire;

use App\producto as AppProducto;
use Livewire\Component;
use Livewire\WithPagination;

class Producto extends Component
{
    use WithPagination;
    public $searchText ;
    public function render()
    {
        $searchText = '%'.$this->searchText.'%';
        return view('livewire.producto',[
            'productos'=>AppProducto::join('categoria','categoria.id','=','producto.idCategoria')
            ->select('producto.nombre','producto.foto','producto.precio','categoria.nombre as categoria','producto.id as idProducto','categoria.id as id Categoria')
            ->where('producto.nombre','LIKE','%'.$searchText.'%')->paginate(10)
        ]);
    }
}
