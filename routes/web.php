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

Route::get('/', 'HomeController@index');

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

Route::get('/Clientes',"ClienteController@index");
Route::get('/Clientes/Alta',"ClienteController@formularioAlta");
Route::post('/Altas/Cliente/altaCliente',"ClienteController@altaCliente");
Route::get('/Clientes/BajaMod',"ClienteController@busqueda");
Route::get('/Clientes/Editar/{idCliente}',"ClienteController@formularioMod");
Route::post('/Modificar/Cliente/editarCliente',"ClienteController@editarCliente");
Route::get('/Clientes/Eliminar/{idCliente}',"ClienteController@eliminar");
Route::get('/Clientes/Buscar',"ClienteController@buscarTodo");
Route::post('/Clientes/buscarNombre',"ClienteController@buscarNombre");

Route::get('/Cotizacion',"CotizacionController@index");
Route::get('/Cotizacion/Alta',"CotizacionController@formulario");
Route::post('/Cotizacion/Alta/altaCotizacion',"CotizacionController@altaCotizacion");
Route::post('/Cotizacion/Generar/PDF',"CotizacionController@generarPDF");
Route::get('/Cotizacion/Busqueda',"CotizacionController@busquedaA");
Route::post('/Cotizacion/buscarCliente',"CotizacionController@buscarCliente");
Route::post('/Cotizacion/Busqueda/buscarCliente',"CotizacionController@buscarCliente2");
Route::get('/Cotizacion/Busqueda/{id}',"CotizacionController@busquedaVer");
Route::get('/Cotizacion/ModBaja',"CotizacionController@busqueda");
Route::get('/Cotizacion/Editar/{id}',"CotizacionController@editar");
Route::post('/Cotizacion/Editar/editarCotizacion',"CotizacionController@editarCotizacion");
Route::get('/Cotizacion/Eliminar/{id}',"CotizacionController@eliminar");

Route::get('/Ventas',"VentasController@index");
Route::get('/Ventas/Alta',"VentasController@formulario");
Route::post('/Ventas/Alta/altaVenta',"VentasController@altaCotizacion");
Route::post('/Ventas/Generar/PDF',"VentasController@generarPDF");
Route::get('/Ventas/Busqueda',"VentasController@busquedaA");
Route::post('/Ventas/buscarCliente',"VentasController@buscarCliente");
Route::post('/Ventas/Busqueda/buscarCliente',"VentasController@buscarCliente2");
Route::get('/Ventas/Busqueda/{id}',"VentasController@busquedaVer");
Route::get('/Ventas/ModBaja',"VentasController@busqueda");
Route::get('/Ventas/Editar/{id}',"VentasController@editar");
Route::post('/Ventas/Editar/editarVenta',"VentasController@editarVenta");
Route::get('/Cotizacion/Eliminar/{id}',"CotizacionController@eliminar");