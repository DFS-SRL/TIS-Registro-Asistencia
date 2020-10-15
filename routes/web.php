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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/planillas/diaria/{user}', 'PlanillaLaboController@obtenerPlanillaDia');

Route::get('/planillas/semanal/auxdoc/{user}', 'PlanillaSemanalAuxDocController@obtenerPlanillaSemana');

Route::get('/planillas/semanal/docente/{user}', 'PlanillaSemanalDocenteController@obtenerPlanillaSemana');