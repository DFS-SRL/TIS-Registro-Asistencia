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

Route::get('/parteMensual/{unidad}', 'ParteMensualController@obtenerParteAuxiliares');

Route::get('/planillas/diaria/{user}', 'PlanillaLaboController@obtenerPlanillaDia');
Route::post('/planillas/diaria', 'PlanillaLaboController@registrarAsistencia')->name('planillas.diaria');

Route::get('/informe/labo/{unidad}/{fecha}', 'PlanillaLaboController@obtenerInformeSemanal');

Route::get('/planillas/semanal/auxdoc/{user}', 'PlanillaSemanalAuxDocController@obtenerPlanillaSemana');
Route::post('/planillas/semanal/auxdoc', 'PlanillaSemanalAuxDocController@registrarAsistencia')->name('planillas.semanal');

Route::get('/planillas/semanal/docente/{user}', 'PlanillaSemanalDocenteController@obtenerPlanillaSemana');

Route::get('/docentes','ProvController\Menu@docentes');
Route::get('/auxiliares','ProvController\Menu@auxiliares');
Route::get('/encargadosAsist','ProvController\Menu@encargadosAsist');
Route::get('/jefesDept','ProvController\Menu@jefesDept');

Route::get('/grupo/{grupo}', 'GrupoController@mostrarInformacion');
Route::get('/materia/{materia}', 'MateriaController@mostrarInformacion');