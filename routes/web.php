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

Route::get('/', function () {
    return view('/provicional/menu');
});

Route::get('/parteMensual/auxiliares/{unidad}/{fecha}', 'ParteMensualController@obtenerParteAuxiliares');
//http://localhost:8000/parteMensual/docentes/1/2020-10-19 
Route::get('/parteMensual/docentes/{unidad}/{fecha}', 'ParteMensualController@obtenerParteDocentes');

Route::get('/planillas/diaria/{user}', 'PlanillaLaboController@obtenerPlanillaDia');
Route::post('/planillas/diaria', 'PlanillaLaboController@registrarAsistencia')->name('planillas.diaria');

// http://localhost:8000/informe/labo/1/2020-10-17 asi es el formato
Route::get('/informes/semanal/laboratorio/{unidad}/{fecha}', 'InformesSemanalesController@obtenerInformeSemanalLabo');
Route::get('/informes/semanal/aux-docencia/{unidad}/{fecha}', 'InformesSemanalesController@obtenerInformeSemanalAuxDoc');
Route::get('/informes/semanal/docencia/{unidad}/{fecha}', 'InformesSemanalesController@obtenerInformeSemanalDoc');

Route::get('/informes/{unidad}', 'InformesController@index');
Route::post('/informes/subir', 'InformesController@subirInformes')->name('informes.subir');
Route::post('/informes/subirFuerza', 'InformesController@subirInformesFuerza')->name('informes.subirFuerza');

Route::get('/planillas/semanal/auxdoc/{user}', 'PlanillaSemanalAuxDocController@obtenerPlanillaSemana');
// Route::post('/planillas/semanal/auxdoc', 'PlanillaSemanalAuxDocController@registrarAsistencia')->name('planillas.semanal');

Route::get('/planillas/semanal/docente/{user}', 'PlanillaSemanalDocenteController@obtenerPlanillaSemana');
// Route::post('/planillas/semanal/docente', 'PlanillaSemanalDocenteController@registrarAsistencia')->name('planillas.semanalDoc');

Route::post('/planillas/semanal/', 'RegistrarAsistenciaSemanal@registrarAsistencia')->name('planillas.semanal');

Route::get('/docentes', 'ProvController\Menu@docentes');
Route::get('/auxiliaresDoc', 'ProvController\Menu@auxiliaresDoc');
Route::get('/auxiliaresLabo', 'ProvController\Menu@auxiliaresLabo');
Route::get('/encargadosAsist', 'ProvController\Menu@encargadosAsist');
Route::get('/jefesDept', 'ProvController\Menu@jefesDept');
Route::get('/departamentos', 'ProvController\Menu@departamentos');

Route::get('/grupo/{grupo}/editar', 'GrupoController@editarInformacion');
Route::get('/grupo/{grupo}', 'GrupoController@mostrarInformacion');
Route::post('/grupo/asignar/docente', 'GrupoController@asignarDocente')->name('grupo.asignar.docente');

Route::get('/materia/{materia}', 'MateriaController@mostrarInformacion');

route::get('/materias/{unidadId}', 'ListaMateriasController@mostrarMaterias');

Route::get('/informes/semanales/{unidad}', 'InformesController@formulario');
// Route::get('/informes/semanales')->name('informes.semanales');
Route::get('/informesSemanales', 'InformesController@verPrueba');