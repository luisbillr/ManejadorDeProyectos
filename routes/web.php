<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\UserController;
use App\Models\Tarea;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::resource('proyecto',ProyectoController::class);
//agrupamos todas las rutas que necesitan que el usuario este autentificado
Route::group(['middleware' => 'auth'], function () {
    // Rutas para el recurso proyecto básicamente las rutas que hacen ABM y listado de Proyectos
    Route::resource('proyecto',ProyectoController::class)->except(['destroy']);
    Route::resource('tarea',TareaController::class)->except(['destroy','index']);
    Route::resource('user',UserController::class);
    // almacena la tarea nueva
    Route::post("proyecto/{proyecto}/tarea",[TareaController::class,'storeTarea'])->name('tarea.storeTarea');
    // elimina una tarea
    Route::delete("proyecto/{proyecto}/tarea/{idTarea}",['as' => 'proyecto.destroyTarea','uses'=>'ProyectoController@destroyTarea']);
    // modifica una tarea el verbo tiene que ser por método put
    // Route::put("proyecto/{proyecto}/tarea/{idTarea}",['as' => 'tarea.updateTarea','uses'=>'ProyectoController@updateTarea']);
    Route::put("proyecto/{proyecto}/tarea/{idTarea}",[TareaController::class,'updateTarea'])->name('tarea.updateTarea');
    //Obtener Jsons y Ajax
    Route::get('usersforproyecto',[ProyectoController::class,'GetUsuariosForProyecto']);
    Route::get('usersfortareas',[ProyectoController::class,'GetUsuariosForTareas']);
    Route::get('GetUsersProyectosInfo',[UserController::class,'GetUsersProyectosInfo']);
    Route::get('GetUsersTareaInfoByIdProyecto',[UserController::class,'GetUsersTareaInfoByIdProyecto']);
    Route::get('GetUsersListOnTareasByIdProyecto',[UserController::class,'GetUsersListOnTareasByIdProyecto']);
  }); 