<?php

use Illuminate\Http\Request;

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


    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
  
  
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
	
	//CompuCaja
	Route::post('cc/receiveTarjetasNuevas', 'CompuCController@receiveTarjetasNuevas');

	Route::post('cc/sendTarjetasActualizadas', 'CompuCController@sendTarjetasActualizadas');
	Route::post('cc/receiveSyncOkTarjetasActualizadas', 'CompuCController@receiveSyncOkTarjetasActualizadas');
	
	Route::post('cc/sendTarjetasPorMigrarSaldo', 'CompuCController@sendTarjetasPorMigrarSaldo');
	Route::post('cc/receiveSyncOkPorMigrarSaldo', 'CompuCController@receiveSyncOkPorMigrarSaldo');
	
	Route::post('cc/receiveSaldoInicial', 'CompuCController@receiveSaldoInicial');

	Route::post('cc/sendSaldo', 'CompuCController@sendSaldo');
	Route::post('cc/receiveSyncOkSaldo', 'CompuCController@receiveSyncOkSaldo');
		
	Route::post('cc/receiveConsumos', 'CompuCController@receiveConsumos');

	Route::post('cc/receiveTiendas', 'CompuCController@receiveTiendas');

	Route::post('cc/sendBd', 'CompuCController@sendBd');
	Route::post('cc/receiveSyncOkBd', 'CompuCController@receiveSyncOkBd');
	
	//Control Gas
	Route::post('cg/sendClientes', 'ControlGasController@sendClientes');
	Route::post('cg/receiveSyncOkClientes', 'ControlGasController@receiveSyncOkClientes');
	

	Route::post('cg/sendTarjetas', 'ControlGasController@sendTarjetas');
	Route::post('cg/receiveSyncOkTarjetas', 'ControlGasController@receiveSyncOkTarjetas');

	Route::post('cg/receiveConsumos', 'ControlGasController@receiveConsumos');
	
	
	