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
        Route::post('clientes/nomegustaagregar','ClientesController@nomegustaagregar');
        Route::post('clientes/baja','ClientesController@baja');
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
    	}
);
