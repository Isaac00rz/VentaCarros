<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/Vendedores',"VendedoresController@index");
Route::get('/Vendedores/Alta',"VendedoresController@formularioAlta");
Route::post('/Altas/Vendedor/altaVendedor',"VendedoresController@altaVendedor");
Route::get('/Vendedores/BajaMod',"VendedoresController@busqueda");
Route::get('/Vendedores/Editar/{idVendedor}',"VendedoresController@formularioMod");
Route::post('/Modificar/Vendedor/editarVendedor',"VendedoresController@editarVendedor");
Route::get('/Vendedores/Eliminar/{idVendedor}',"VendedoresController@eliminar");
Route::get('/Vendedores/Buscar',"VendedoresController@buscarTodo");
Route::post('/Vendedores/buscarNombre',"VendedoresController@buscarNombre");
