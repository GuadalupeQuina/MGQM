<?php

namespace App\Http\Livewire;

use App\listaMenu;
use App\pedido;
use App\producto;
use Livewire\Component;

class Pedidos extends Component
{
    public $formulario = 0;
    public $actualizar = 0;
    public $usuario_id ;

    public $fechaEntrega;
    public $total;
    public $subTotal;
    public $cantidad;



    public $arrayProducto=[
    ]; 

    public function render(){

        return view('livewire.pedidos',[
            'pedidos'=>pedido::join('ubicacion','ubicacion.id','=','pedido.idUbicacion')
            ->join('users','users.id','pedido.idUsuario')
            ->join('cliente','cliente.id','pedido.idCliente')
            ->join('repartidor','repartidor.id','pedido.idrepartidor')
            ->join('detallepedido','detallepedido.idPedido','pedido.id')
            
            ->select(
                'pedido.fecha',
                'pedido.fechaentrega',
                'pedido.horaentrega',
                'pedido.glosa',
                'pedido.montototal',
                'pedido.estado',
                //0  realizado   // 1 enviado   // 2 entregado
    
                'pedido.idUsuario',
                'pedido.idCliente',
                'pedido.idRepartidor',
                'pedido.idUbicacion'              
             )
            ->where('pedido.estado','=',0)
            ->paginate(10)
        ,  'menu'=> listaMenu::join('producto','producto.id','=','listamenu.idProducto')
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
            ->orderBy('producto.id', 'desc')->paginate(5) ]);

    }
    public function mostrarFormulario(){
        $this->formulario = 1;
    }
    public function mostrarFormularioGuardar(){
        $this->mostrarFormulario();
    }
    public function mostrarFormularioActualizar(){

    }
    public function agregarProductoArray($producto){
        // $producto = producto::findOrFail($producto_id);
        array_push($this->arrayProducto,$producto);
        array_push($this->arrayProducto,1);

    }
}
