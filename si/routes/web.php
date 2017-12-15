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

// Link principal
Route::get('/',function(){
    return redirect('inicio');
});

// Cerrar sesión
Route::get('/si/cerrarSesion','SesionController@CerrarSesion');

// Ingreso a la plataforma
Route::post('/ingresar/verificar','SesionController@VerificarUsuario');

// Navegacion por las carpetas del administrador
Route::get('/si/{carpeta}/{pagina}','NavegacionController@Privado');

// Acciones de todos los modulos para consultar, crear, editar y eliminar 
Route::post('/{carpeta}/{pagina}/{crud}','FuncionesVariablesController@AsignarFuncion');

// Navegacion de las carpetas de administrador parte principal
Route::get('/{carpeta}/{pagina}','NavegacionController@Privado');

// Navegacion de la parte publica o el home de la pagina
Route::get('/{pagina}','NavegacionController@Publico');
