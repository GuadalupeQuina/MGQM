<?php

use App\cliente;
use App\detallePedido;
use App\listaMenu;
use App\menu;
use App\pedido;
use App\User;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/index', function () {
    return view('contenido.contenido');
});






//----------CATEGORIA-------------////
Route::get('categoria','ctrlCategoria@index');
Route::post('categoria/guardar','ctrlCategoria@store');
Route::post('categoria/actualizar','ctrlCategoria@update');
Route::post('categoria/eliminar','ctrlCategoria@delete');
Route::get('/categoria/selectCategoria', 'ctrlCategoria@selectCategoria');



/////----------------Producto-----------------///
Route::get('producto','ctrlProducto@mostrar');
Route::post('producto/guardar','ctrlProducto@guardar');
Route::post('producto/modificar','ctrlProducto@modificar');
Route::post('producto/eliminar','ctrlProducto@eliminar');
Route::get('producto/buscarProducto','ctrlProducto@buscarProducto');
Route::get('producto/buscarProductoCategoria','ctrlProducto@buscarProductoCategoria');

Route::get('/producto/menu','ctrlProducto@productoMenu');
Route::get('/producto/selectProducto', 'ctrlProducto@selectProducto');
Route::get('/producto/menuProducto', 'ctrlProducto@menuProducto');
Route::get('/producto/listaMenuProducto', 'ctrlProducto@listaMenuProducto');




// /producto/listaMenuProducto?buscar='+ buscar + '&criterio='+ criterio

// Route::get('/producto/buscarProducto', 'ctrlProducto@buscarProducto');



/////----------------Mesa-----------------///
Route::get('mesa','ctrlMesa@mostrar');
Route::post('mesa/guardar','ctrlMesa@guardar');
Route::post('mesa/modificar','ctrlMesa@modificar');
Route::post('mesa/libre','ctrlMesa@libre');
Route::post('mesa/ocupado','ctrlMesa@ocupado');
Route::post('mesa/eliminar','ctrlMesa@eliminar');



/////----------------Rol-----------------///
Route::get('rol','ctrlRol@rolUser');

/////----------------Menú-----------------///
Route::get('menu','ctrlMenu@mostrar');
Route::post('menu/guardar','ctrlMenu@guardar');
Route::post('menu/activar','ctrlMenu@activar');
Route::post('menu/desactivar','ctrlMenu@desactivar');
Route::post('menu/eliminar','ctrlMenu@eliminarMenu');
Route::get('menu/allMenu','ctrlMenu@allMenus');



/////----------------Cliente-----------------///
Route::get('cliente','ctrlCliente@index');
Route::post('cliente/guardar','ctrlCliente@store');
Route::post('cliente/actualizar','ctrlCliente@update');
Route::post('cliente/activar','ctrlCliente@activar');
Route::post('cliente/desactivar','ctrlCliente@desactivar');
Route::post('cliente/eliminar','ctrlCliente@delete');
Route::get('/cliente/selectCliente','ctrlCliente@selectCliente'); 
Route::get('/cliente/dato','ctrlCliente@datoUser'); 

/////----------------Usuario-----------------///
Route::get('usuario','ctrlUsuario@index');
Route::post('usuario/guardar','ctrlUsuario@guardar');


/////---------------Orden---------------------------- ///////
Route::post('/ordenAtencion/guardar', 'ctrlOrdenAtencion@guardar');
Route::get('detalleOrden/buscar','ctrlOrdenAtencion@buscarDetalle');
Route::post('detalleOrden/modificar','ctrlOrdenAtencion@modificarDetalle');
Route::post('/finalizar/orden','ctrlOrdenAtencion@finalizarOrden');



Route::post('/item/eliminar','ctrlOrdenAtencion@itemEliminar');
Route::post('/item/actualizar','ctrlOrdenAtencion@itemActualizar');



//////------------------Detalle-----------------------------///////
Route::post('/agregar/producto/detalle','ctrlOrdenAtencion@agregarProductoDetalle');


/////----------------Repartidor-----------------///
Route::get('repartidor','ctrlRepartidor@index');
Route::post('repartidor/guardar','ctrlRepartidor@store');
Route::post('repartidor/actualizar','ctrlRepartidor@update');
Route::post('repartidor/eliminar','ctrlRepartidor@delete');
Route::get('/repartidor/selectRepartidor', 'ctrlRepartidor@selectRepartidor');




/////----------------Tipo-----------------///
Route::get('tipo','ctrlTipo@index');
Route::post('tipo/guardar','ctrlTipo@store');
Route::put('tipo/actualizar','ctrlTipo@update');
Route::put('tipo/eliminar','ctrlTipo@delete');

/////----------------Vehiculo-----------------///
Route::get('vehiculo','ctrlVehiculo@mostrar');
Route::post('vehiculo/guardar','ctrlVehiculo@guardar');
Route::post('vehiculo/modificar','ctrlVehiculo@modificar');
Route::post('vehiculo/eliminar','ctrlVehiculo@eliminar');

//------------------reserva----------------//

Route::get('reserva'           ,'ctrlReserva@mostrar');
Route::post('reserva/guardar'  ,'ctrlReserva@guardar');
Route::post('reserva/modificar','ctrlReserva@modificar');
Route::post('reserva/eliminar' ,'ctrlReserva@eliminar');

Route::get('reservaCliente','ctrlReserva@mostrarReservaCliente');
Route::post('reserva/cliente/guardar','ctrlReserva@guardarReservaCliente');
Route::post('reserva/cliente/modificar','ctrlReserva@modificarReservaCliente');






//   Usuario
Route::get('/usuario/autenticado', 'ctrlUsuario@authenticado' );


Route::get('bitacora','ctrlBitacora@mostrar');



Route::get('prueba', function () {

    $criterio = 5;
        
        $productoMenu = listaMenu::join('menu','menu.id','=','listamenu.idMenu')
        ->join('producto','producto.id','listamenu.idProducto')
        ->select('producto.id','producto.foto','producto.nombre','producto.precio','listamenu.estado')->where('menu.id','=',$criterio)->get(); 
        
        return [
        'productoMenu'=> $productoMenu
        ];

    $fecha = date('Y-m-d');
    $menus = menu::select('categoria.nombre as categoria','menu.idCategoria','menu.fecha','menu.estado')
    ->join('categoria','categoria.id','=','menu.idCategoria')
    ->where('fecha','=',$fecha)->where('menu.estado','=',1)
    ->get();
    return ["menu"=>$menus];


    
    $fecha      = '2020-10-01';
    $sw         = false;
    $categoria  = 1;


    $menu = menu::select('fecha')
                ->where('idCategoria','=',$categoria)
                ->where('fecha','=',$fecha)
                ->get();

    $todos = menu::where('idCategoria','=',$categoria)
                ->where('fecha','=',$fecha)
                ->get();

    foreach ($todos as $key => $value) {
        $value->estado = 0;
        $value->update();
    }

    $count = count($menu);
    
    if($count){
        $sw=true;
    }
    return ["existe"=> $sw, "todos"=>$todos];

    $id = $menu[0]->id;


    $menuExiste = menu::findOrFail($id);
    

    $count = count($menu);
    if($count){
        $sw=true;
    }
    return ["id" => $id,"existe"=>$sw, "menu " => $menu, "fecha"=>$fecha , 'idCategoria'=>$categoria];

    // $id = Auth::id(); 
    // $user = User::findOrFail($id);
    // $rol = $user->roles;

    $rol = Auth::user()->roles;
    $AuthRol = $rol[0]->name;
    
    return ["rol" => $AuthRol ];




    $pedidos=detallePedido::join('pedido','pedido.id','detallepedido.idPedido')
    ->join('producto','detallepedido.idProducto','producto.id')
    
    ->select(
        'pedido.fecha',
        'pedido.fechaentrega',
        'pedido.horaentrega',
        'pedido.glosa',
        'pedido.montototal',
        'pedido.estado'
        //0  realizado   // 1 enviado   // 2 entregado
     )
    ->where('pedido.estado','=',0)
    ->paginate(10);

    return $pedidos;
});




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
