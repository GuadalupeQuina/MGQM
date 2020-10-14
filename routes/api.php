<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('prueba','PruebaController@prueba');
Route::get('rol','PruebaController@rolUser');

Route::get('insertar/cliente','PruebaController@clienteusuario');
Route::get('eliminar/cliente','PruebaController@eliminarClienteUsuario');

Route::get('insertar/repartidor','PruebaController@repartidorUsuario');


Route::get('insertar/reserva','PruebaController@reserva');
Route::get('insertar/mesa','PruebaController@mesas');
Route::get('insertar/vehiculo','PruebaController@vehiculo');




Route::get('insertar/usuario','PruebaController@insertarUsuario');



Route::get('insertar/prueba','PruebaController@usuarioPrueba');