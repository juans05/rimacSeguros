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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'PersonaController@index');




Route::get('/addaplicativo/{slug}', ['as' => 'add_cuenta-grabar', 'uses' => 'AplicativoController@addAplicativoPersona']);
Route::get('/aplicativos/{slug}', ['as' => 'ver-cuenta-usu', 'uses' => 'AplicativoController@verCuentaAplicativo']);

Route::get('/aplicativo/{slug}', ['as' => 'add_cerrar_cuenta-grabar', 'uses' => 'AplicativoController@cerrarTicket']);
Route::get('/configuracion', ['as' => 'configuracion-area', 'uses' => 'AplicativoController@areaporAplicativo']);




Route::get('/eliminarcuenta/{idcuenta}/{WO}', ['as' => 'cuenta-eliminar', 'uses' => 'CuentaController@eliminarCuenta']);
Route::get('/personas', ['as' => 'listar-personas', 'uses' => 'PersonaController@listar_personas']);

Route::post('/ticket', ['as' => 'add_vinculare-grabar_vinculacion', 'uses' => 'CuentaController@agregar_aplicativo_nuevo']);




//consultas
Route::get('/busqueda/{idcuenta}', ['as' => 'busqueda-cuenta', 'uses' => 'PersonaController@busquedaAvanzada']);
Route::get('/busqueda/{idcuenta}/{name}', ['as' => 'busqueda-cuenta-lista_personas', 'uses' => 'PersonaController@busquedaAvanzadaVincular']);

//nueva vinculacion de ticket
Route::get('/personas/{idPersona}/{ticketPadre}', ['as' => 'add_vinculare_ticket-grabar', 'uses' => 'PersonaController@vinculacion_nuevo_ticket_persona']);


Route::controllers([
   	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::resource('persona','PersonaController');
Route::resource('cuenta','CuentaController');
Route::get('/getInfo', ['as' => 'getInfo', 'uses' => 'PersonaController@getInfo']);
Route::get('/aplicativoConsulta/{area}','AplicativoController@armarGrilla');
Route::get('/aplicativoFaltante/{area}','AplicativoController@aplicativoFaltante');
Route::post('/aplicativo/{area}/{aplicativo}', ['as' => 'registrar-area-aplicativo', 'uses' => 'AplicativoController@registroNuevoAplicativo']);
Route::post('/aplicativo/{id}/{idArea}', ['as' => 'eliminar-area-aplicativo', 'uses' => 'AplicativoController@eliminarAreaAplicativo']);



Route::group(['middleware'=>['auth','is_admin']], function() {
    Route::post('/EliminarAplicativo/{idTicket}/{idAplicativo}', ['as' => 'eliminar-persona-aplicativo', 'uses' => 'AplicativoController@EliminarAplicativoTicket']);
    Route::post('/Aplicativo/{idTicket}', ['as' => 'registrar-aplicativoticket', 'uses' => 'AplicativoController@registrarAplicativo']);
    Route::post('/EliminarPersona/{idTicket}', ['as' => 'eliminar-persona', 'uses' => 'PersonaController@EliminarPersona']);

    Route::get('/modificar/{id}', ['as' => 'modificar-cuenta', 'uses' => 'PersonaController@modificar_cuenta']);
    Route::post('/modificar/', ['as' => 'actualizar-cuenta', 'uses' => 'PersonaController@update']);


     Route::post('/entregado/{slug}', ['as' => 'cuenta-cambiar', 'uses' => 'CuentaController@cuentaCambiar']);

    Route::post('/aplicativo2', ['as' => 'cuenta-grabar2', 'uses' => 'CuentaController@create']);
    Route::post('/cuenta/{slug}', ['as' => 'cuenta-exportar', 'uses' => 'CuentaController@exportarCuenta']);


//cargar excel
    Route::get('/cargarExcel', ['as' => 'cargar-data', 'uses' => 'CuentaController@cargarExcel']);
    Route::post('/cargarExceldata', ['as' => 'cargar-data-excel', 'uses' => 'CuentaController@cargarData_excel']);
    //Route::post('/cargarExceldata', ['as' => 'cargar-data-excel-masivo', 'uses' => 'CuentaController@cargarDataMasiva']);
    // Route::get('/cargarExcelmasivo', ['as' => 'cargar-data-masivo2', 'uses' => 'CuentaController@cargarExcel_masiva']);
});