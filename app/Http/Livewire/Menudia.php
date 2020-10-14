<?php

namespace App\Http\Livewire;

use App\listaMenu;
use Livewire\Component;

class Menudia extends Component
{
    public function render()
    {
        return view('livewire.menudia',[
            'menu'=> listaMenu::join('producto','producto.id','=','listamenu.idProducto')
            ->join('menu','menu.id','listamenu.idMenu')
            ->select('producto.id as idProducto',
                        'listamenu.id',
                        'producto.idCategoria',
                        'producto.nombre',
                        'producto.precio',
                        'producto.foto',
                        'producto.precio',
                        'producto.descripcion'
                        )
            ->where('menu.estado','=',1)
            ->orderBy('producto.id', 'desc')->paginate(5)
        ]);
    }
}
