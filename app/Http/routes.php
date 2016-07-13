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

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::group(['prefix'=>'admin','namespace'=>'Admin'],
    function(){
        Route::get('/','HomeController@index');
        Route::resource('home','HomeController');
        Route::post('modificarclave','HomeController@modificarclave');

        Route::resource('tiposalimentos','TiposAlimentosController');
        Route::post('tiposalimentos/buscar','TiposAlimentosController@buscar');

        Route::resource('alimentos','AlimentosController');
        Route::post('alimentos/buscar','AlimentosController@buscar');

        Route::resource('nolaborables','NoLaborablesController');
        Route::post('nolaborables/buscar','NoLaborablesController@buscar');

        Route::resource('tiposviandas','TiposViandasController');
        Route::post('tiposviandas/buscar','TiposViandasController@buscar');

        Route::resource('clientes','ClientesController');
        Route::get('clientes/nomegusta/{id}','ClientesController@nomegusta');

       // Route::get('clientes/nomegusta/{id}', ['as' => 'book_view', 'uses' => 'ClientesController@nomegusta']);


        Route::post('clientes/nomegustaagregar','ClientesController@nomegustaagregar');
        Route::post('clientes/baja','ClientesController@baja');
        Route::post('clientes/alta','ClientesController@alta');
        Route::get('clientes/like/like','ClientesController@likecliente');
        Route::get('clientesdebaja','ClientesController@listaDeBaja');
        
        Route::get('loquenogusta','ClientesController@nomegustalista');
        Route::get('clientes/gestionar/{id}','ClientesController@gestionarcliente');

        Route::resource('gastos','GastosController');
        Route::post('gastos/buscarxfechas','GastosController@buscarxfechas');
        Route::post('gastos/buscar','GastosController@buscar');

        Route::resource('tipogastos','TipoGastosController');
        Route::post('tipogastos/buscar','TipoGastosController@buscar');

        Route::resource('viandas','ViandasController');
        Route::post('viandas/buscartodas','ViandasController@buscarTodas');
        Route::post('viandas/buscar','ViandasController@buscar');

        Route::resource('empresas','EmpresasController');
        Route::post('empresas/buscar','EmpresasController@buscar');
        Route::post('empresas/preciovianda','EmpresasController@preciovianda');
        Route::post('empresas/precioviandaeliminar','EmpresasController@precioviandaeliminar');

        Route::resource('localidades','LocalidadesController');
        Route::post('localidades/buscar','LocalidadesController@buscar');

        Route::resource('cadetes','CadetesController');
        Route::post('cadetes/buscar','CadetesController@buscar');

        Route::resource('viandasclientes','ViandasClientesController');

        Route::resource('pedidos','PedidosController');
        Route::post('pedidos/buscar','PedidosController@buscar');
        Route::post('pedidos/agregarPedidoManual','PedidosController@agregarPedidoManual');
        Route::get('pedido/gestion','PedidosController@gestion');
        Route::post('pedidos/buscarpedidos','PedidosController@buscarpedidos');

        Route::get('cobros','PedidosController@listarPedidos');
        
        Route::post('cobros/buscarcobros','PedidosController@buscarCobros');

        Route::get('cobros/buscarcobrosajax', 'PedidosController@buscarCobrosAjax');

        
        Route::get('cobros/actualizarcobros', 'PedidosController@actualizarCobros');



        Route::resource('reportes','PdfController');
        Route::get('repor/planillasemanal','PdfController@planillasemanal');


    	}
);
