<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'almacen'], function () {
    Route::resource('marca','MarcaController');
    Route::resource('categoria','CategoriaController');
    Route::resource('modelo','ModeloController');
    Route::resource('producto','ProductoController');
});

Route::group(['prefix' => 'usuarios'], function () {
    Route::resource('trabajador','TrabajadorController');
    Route::resource('tipo','TipoUsuarioController');
    Route::resource('usuario','UsuarioController');
});

Route::post('login/CargarPerfiles','LoginController@CargarPerfiles');

Route::group(['prefix' => 'ventas'],function(){
    Route::resource('venta','VentaController');
    Route::resource('cliente','ClienteController');
});

Route::post('ventas/venta/create/ByProducto/{id?}', 'VentaController@ByProducto');
Route::get('ventas/venta/create/getMarcas', 'VentaController@getMarcas');

Route::get('marca/getmarcasInfo','MarcaController@get_marca_info');
Route::get('listamarcas/{page?}','MarcaController@listamarcas');
Route::get('marca/getmarcasinfosearch','MarcaController@getmarcasinfosearch');

Route::get('categoria/getcategoriasInfo','CategoriaController@get_categoria_info');
Route::get('listacategorias/{page?}','CategoriaController@listacategorias');
Route::get('categoria/getcategoriasinfosearch','CategoriaController@getcategoriasinfosearch');

Route::get('modelo/getmodelosInfo','ModeloController@get_modelo_info');
Route::get('listamodelos/{page?}','ModeloController@listamodelos');
Route::get('modelo/getmodelosinfosearch','ModeloController@getmodelosinfosearch');

Route::get('producto/getproductosInfo','ProductoController@get_producto_info');
Route::get('listaproductos/{page?}','ProductoController@listaproductos');
Route::get('producto/getproductosinfosearch','ProductoController@getproductosinfosearch');

Route::get('trabajador/gettrabajadoresInfo','TrabajadorController@get_trabajador_info');
Route::get('listatrabajadores/{page?}','TrabajadorController@listatrabajadores');
Route::get('trabajador/gettrabajadoresinfosearch','TrabajadorController@gettrabajadoresinfosearch');

Route::get('tipo/gettiposInfo','TipoUsuarioController@get_tipo_info');
Route::get('listatipos/{page?}','TipoUsuarioController@listatipos');
Route::get('tipo/gettiposinfosearch','TipoUsuarioController@gettiposinfosearch');

Route::get('usuario/getusuariosInfo','UsuarioController@get_usuario_info');
Route::get('listausuario/{page?}','UsuarioController@listausuarios');
Route::get('usuario/getusuariosinfosearch','UsuarioController@getusuariosinfosearch');

Route::auth();

Route::get('/home', 'HomeController@index');