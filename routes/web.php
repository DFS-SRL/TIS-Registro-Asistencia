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

use Illuminate\Support\Facades\Route;

Route::view('/', 'provicional.menu')->name('home');

Route::view('/acerca-de', 'provicional.acerca-de')->name('about');

Route::get('/parteMensual/auxiliares/{unidad}/{fecha}', 'ParteMensualController@obtenerParteAuxiliares');
//http://localhost:8000/parteMensual/docentes/1/2020-10-19 
Route::get('/parteMensual/docentes/{unidad}/{fecha}', 'ParteMensualController@obtenerParteDocentes');

Route::get('/planillas/diaria/{user}', 'PlanillaLaboController@obtenerPlanillaDia');
Route::post('/planillas/diaria', 'PlanillaLaboController@registrarAsistencia')->name('planillas.diaria');

// http://localhost:8000/informe/labo/1/2020-10-17 asi es el formato
Route::get('/informes/semanal/laboratorio/{unidad}/{fecha}', 'InformesSemanalesController@obtenerInformeSemanalLabo');
Route::get('/informes/semanal/aux-docencia/{unidad}/{fecha}', 'InformesSemanalesController@obtenerInformeSemanalAuxDoc');
Route::get('/informes/semanal/docencia/{unidad}/{fecha}', 'InformesSemanalesController@obtenerInformeSemanalDoc');

Route::get('/informes/{unidad}', 'InformesController@index')->name('informes');
Route::post('/informes/subir', 'InformesController@subirInformes')->name('informes.subir');
Route::post('/informes/subirFuerza', 'InformesController@subirInformesFuerza')->name('informes.subirFuerza');

Route::get('/planillas/semanal/auxdoc/{user}', 'PlanillaSemanalController@obtenerPlanillaSemanalAuxDoc');
Route::get('/planillas/semanal/docente/{user}', 'PlanillaSemanalController@obtenerPlanillaSemanalDocente');
Route::post('/planillas/semanal/', 'PlanillaSemanalController@registrarAsistenciasSemana')->name('planillas.semanal');

Route::get('/buscarPersonalAcademico/{unidad}', 'usuarioController@mostrarBuscarPersonal');
Route::post('/personalAcademico/{unidad}/buscar', 'usuarioController@buscarPersonal')->name('personalAcademico.buscar');
Route::get('/personalAcademico/{unidad}', 'usuarioController@obtenerPersonal')->name('personalAcademico.obtenerPersonal');

Route::get('/docentes', 'ProvController\Menu@docentes')->name('docentes');
Route::get('/auxiliaresDoc', 'ProvController\Menu@auxiliaresDoc')->name('auxiliaresDoc');
Route::get('/auxiliaresLabo', 'ProvController\Menu@auxiliaresLabo')->name('auxiliaresLabo');
Route::get('/encargadosAsist', 'ProvController\Menu@encargadosAsist');
Route::get('/jefesDept', 'ProvController\Menu@jefesDept');
Route::get('/departamentos', 'ProvController\Menu@departamentos')->name('departamentos');

Route::get('/grupo/{grupo}/editar', 'GrupoController@editarInformacion');
Route::post('/grupo/{grupo}/editar/esDocente', 'GrupoController@esDocente')->name('grupo.editar.esDocente');
Route::post('/grupo/{grupo}/editar/esAuxDoc', 'GrupoController@esAuxDoc')->name('grupo.editar.esAuxDoc');
Route::get('/grupo/{grupo}', 'GrupoController@mostrarInformacion');
Route::patch('/grupo/asignar/docente', 'GrupoController@asignarDocente')->name('grupo.asignar.docente');
Route::patch('/grupo/asignar/auxDoc', 'GrupoController@asignarAuxDoc')->name('grupo.asignar.auxDoc');
Route::patch('/grupo/{grupo}/desasignar/docente', 'GrupoController@desasignarDocente')->name('grupo.desasignar.docente');
Route::patch('/grupo/{grupo}/desasignar/auxiliar', 'GrupoController@desasignarAuxiliar')->name('grupo.desasignar.auxiliar');

Route::get('/item/{grupo}', 'GrupoController@mostrarInformacion');
Route::get('/item/{grupo}/editar', 'GrupoController@editarInformacion');
Route::patch('/item/asignar/auxLabo', 'GrupoController@asignarAuxLabo')->name('item.asignar.auxLabo');

Route::post('/horarioClase', 'HorarioClaseController@guardar')->name('horarioClase.guardar');
Route::patch('/horarioClase/{horario}', 'HorarioClaseController@actualizar')->name('horarioClase.actualizar');
Route::delete('/horarioClase/{horario}', 'HorarioClaseController@eliminar')->name('horarioClase.eliminar');

Route::get('/materia/{materia}', 'MateriaController@mostrarInformacion');

route::get('/materias/{unidadId}', 'ListaMateriasController@mostrarMaterias');

Route::get('/informes/semanales/{unidad}', 'InformesController@formulario')->name('informes.semanales');

Route::get('/cargo/{materia}', 'MateriaController@mostrarInformacion');

Route::get('/cargos/{unidad}', 'ListaMateriasController@mostrarCargosDeLaboratorio');