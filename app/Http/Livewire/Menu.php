<?php

namespace App\Http\Livewire;

use App\listaMenu;
use App\menu as AppMenu;
use Livewire\Component;
use Livewire\WithPagination;

class Menu extends Component{


    use WithPagination;
    public $searchText ;

    public $fecha ;
    public function render(){
        
        $searchText = '%'.$this->searchText.'%';
        
        return view('livewire.menu',[
            'menu' => listaMenu::join('producto','producto.id','=','listamenu.idProducto')
            ->join('menu','menu.id','=','listamenu.idMenu')->
            where('producto.nombre','LIKE','%'.$searchText.'%')->where('menu.estado','=',1)
            ->paginate(10)
        ]);
    }
}
