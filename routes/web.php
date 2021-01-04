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

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Route::view('/', 'provicional.menu')->middleware('auth')->name('home');

Route::view('/acerca-de', 'provicional.acerca-de')->name('about');

Route::get('/parteMensual/auxiliares/{unidad}/{fecha}', 'ParteMensualController@obtenerParteAuxiliares');
Route::get('/parteMensual/auxiliares/{unidad}/{fecha}/descargarPDF', 'ParteMensualController@descargarPDFAuxiliares');

Route::get('/facultades','FacultadController@listaFacultades')->name('facultades');
Route::get('/facultades/{facultad}','FacultadController@listaDepartamentos');
Route::get('/facultades/{facultad}/{fecha}','ParteMensualController@partesMesFacultad');


//http://localhost:8000/parteMensual/docentes/1/2020-10-19 
Route::get('/parteMensual/docentes/{unidad}/{fecha}', 'ParteMensualController@obtenerParteDocentes');
Route::get('/parteMensual/docentes/{unidad}/{fecha}/descargarPDF', 'ParteMensualController@descargarPDFDocentes');


Route::get('/planillas/diaria/{user}', 'PlanillaLaboController@obtenerPlanillaDia')
    ->name('planillas.diaria.obtener');
Route::post('/planillas/diaria', 'PlanillaLaboController@registrarAsistencia')->name('planillas.diaria');

// http://localhost:8000/informe/labo/1/2020-10-17 asi es el formato
Route::get('/informes/semanal/laboratorio/{unidad}/{fecha}', 'InformesController@obtenerInformeSemanalLabo');
Route::get('/informes/semanal/aux-docencia/{unidad}/{fecha}', 'InformesController@obtenerInformeSemanalAuxDoc');
Route::get('/informes/semanal/docencia/{unidad}/{fecha}', 'InformesController@obtenerInformeSemanalDoc');

Route::get('/informes/semanal/personal/{usuario}/{fecha}', 'InformesController@obtenerInformeSemanalUsuario');

Route::get('/informes/mensual/{unidad}/{fecha}/docente/{usuario}', 'InformesController@obtenerInformeMensualDocente')
    ->name('informes.mensual.docente');
Route::get('/informes/mensual/{unidad}/{fecha}/auxiliar/{usuario}', 'InformesController@obtenerInformeMensualAuxiliar')
    ->name('informes.mensual.auxiliar');

Route::get('/informes/semanal/{unidad}/{fecha}/auxiliar/{usuario}/{jefe}', 'InformesController@obtenerPlanillaExcepcionAuxiliares')
    ->name('informes.semanales.excepcionAuxiliares');

Route::get('/planillas/semanal/excepcion/auxiliar/{unidad}/{usuario}', 'PlanillaSemanalController@obtenerPlanillaExcepcionAuxiliar')
    ->name('planilla.excepcion.auxiliar');
Route::get('/planillas/semanal/excepcion/docente/{unidad}/{usuario}', 'PlanillaSemanalController@obtenerPlanillaExcepcionDocente')
    ->name('planilla.excepcion.docente');

Route::get('/informes/{unidad}', 'InformesController@index')->name('informes');
Route::post('/informes/subir', 'InformesController@subirInformes')->name('informes.subir');
Route::post('/informes/subirFuerza', 'InformesController@subirInformesFuerza')->name('informes.subirFuerza');

Route::get('/planillas/semanal/auxdoc/{user}', 'PlanillaSemanalController@obtenerPlanillaSemanalAuxDoc')
    ->name('planillas.semanal.auxdoc');;
Route::get('/planillas/semanal/docente/{user}', 'PlanillaSemanalController@obtenerPlanillaSemanalDocente')
    ->name('planillas.semanal.docente');
Route::post('/planillas/semanal/', 'PlanillaSemanalController@registrarAsistenciasSemana')->name('planillas.semanal');

Route::get('/docentes', 'ProvController\Menu@docentes')->name('docentes');
Route::get('/docente/{usuario}', 'ProvController\Menu@docente')->name('docente');
Route::get('/auxiliaresDoc', 'ProvController\Menu@auxiliaresDoc')->name('auxiliaresDoc');
Route::get('/auxiliarDoc/{usuario}', 'ProvController\Menu@auxiliarDoc')->name('auxiliarDoc');
Route::get('/auxiliaresLabo', 'ProvController\Menu@auxiliaresLabo')->name('auxiliaresLabo');
Route::get('/auxiliarLabo/{usuario}', 'ProvController\Menu@auxiliarLabo')->name('auxiliarLabo');
Route::get('/encargadosAsist', 'ProvController\Menu@encargadosAsist');
Route::get('/jefesDept', 'ProvController\Menu@jefesDept');
// Route::get('/departamentos', 'ProvController\Menu@departamentos')->name('departamentos');
Route::get('/departamentos', 'FacultadController@listaTodosDepartamentos')->name('departamentos');

Route::get('/grupo/{grupo}/editar', 'GrupoController@editarInformacion');
Route::post('/grupo/{grupo}/editar/esDocente', 'GrupoController@esDocente')->name('grupo.editar.esDocente');
Route::post('/grupo/{grupo}/editar/esAuxDoc', 'GrupoController@esAuxDoc')->name('grupo.editar.esAuxDoc');
Route::get('/grupo/{grupo}', 'GrupoController@mostrarInformacion')->name('grupo.informacion');
Route::patch('/grupo/asignar/docente', 'GrupoController@asignarDocente')->name('grupo.asignar.docente');
Route::patch('/grupo/asignar/auxDoc', 'GrupoController@asignarAuxDoc')->name('grupo.asignar.auxDoc');
Route::patch('/grupo/{grupo}/desasignar/docente', 'GrupoController@desasignarDocente')->name('grupo.desasignar.docente');
Route::patch('/grupo/{grupo}/desasignar/auxiliar', 'GrupoController@desasignarAuxiliar')->name('grupo.desasignar.auxiliar');
Route::patch('/grupo/{grupo}/desasignar/auxiliarLabo', 'GrupoController@desasignarAuxiliarDeLaboratorio')->name('grupo.desasignar.auxiliarLaboratorio');

Route::get('/item/{grupo}', 'GrupoController@mostrarInformacionItem')->name('item.informacion');
Route::get('/item/{grupo}/editar', 'GrupoController@editarInformacionItem');
Route::patch('/item/asignar/auxLabo', 'GrupoController@asignarAuxLabo')->name('item.asignar.auxLabo');

Route::post('/horarioClase', 'HorarioClaseController@guardar')->name('horarioClase.guardar');
Route::patch('/horarioClase/{horario}', 'HorarioClaseController@actualizar')->name('horarioClase.actualizar');
Route::delete('/horarioClase/{horario}', 'HorarioClaseController@eliminar')->name('horarioClase.eliminar');

Route::patch('/asistencia/{asistencia}', 'AsistenciaController@actualizar')->name('asistencia.actualizar');
Route::patch('/asistencia/{asistencia}/permiso', 'AsistenciaController@permisoEdicion')->name('asistencia.permiso');

Route::get('/materia/{materia}', 'MateriaController@mostrarInformacion')->name('materia.informacion');
Route::delete('/materia/{materia}', 'MateriaController@eliminarMateria');
Route::post('/materia/guardar', 'MateriaController@guardarMateria')->name('materia.guardar');

route::get('/materias/{unidadId}', 'ListaMateriasController@mostrarMaterias');
route::get('/materias/{unidadId}/editar', 'ListaMateriasController@editarListaMaterias');

Route::get('/informes/semanales/{unidad}', 'InformesController@formularioUnidad')->name('informes.semanales');
Route::get('/informes/semanales/personal/{usuario}', 'InformesController@formularioUsuario')->name('informes.semanales.personal');


Route::get('/departamento/{unidad}', 'UnidadController@informacionDepartamento')->name('departamento');
Route::get('/partes/mensuales/{unidad}', 'UnidadController@obtenerParte')->name('partes.mensuales');
Route::patch('/aprobarParteMensualRol', 'ParteMensualController@aprobarPartePorRol')->name('aprobarParteRol');
Route::patch('/enviarDPA', 'ParteMensualController@enviarDPA')->name('enviarPartesDPA');

Route::get('/cargo/{materia}', 'MateriaController@mostrarInformacion')->name('cargo.informacion');
Route::delete('/cargo/{materia}', 'MateriaController@eliminarMateria');
Route::post('/cargo/guardar', 'MateriaController@guardarMateria')->name('cargo.guardar');


Route::get('/cargos/{unidad}', 'ListaMateriasController@mostrarCargosDeLaboratorio');
route::get('/cargos/{unidad}/editar', 'ListaMateriasController@editarListaCargosDeLabo');

Route::get('/personalAcademico/registrar/{unidad}', 'PersonalAcademicoController@mostrarRegistro')->name('personalAcademico.mostrarRegistro');
Route::get('/personalAcademico/registrar/{unidad}/verificar', 'PersonalAcademicoController@verificarCodsis')->name('personalAcademico.verificar');
route::post('/personalAcademico/registrar/{unidad}', 'PersonalAcademicoController@registrarPersonalAcademico')->name('personalAcademico.registrar');

Route::get('/personalAcademico/{unidad}', 'PersonalAcademicoController@obtenerPersonal')->name('informacion.personalAcademico');
Route::get('/personalAcademico/{unidad}/docente/{usuario}', 'PersonalAcademicoController@informacionDocente')->name('informacion.docente');
Route::get('/personalAcademico/{unidad}/auxiliar/{usuario}', 'PersonalAcademicoController@informacionAuxiliar')->name('informacion.auxiliar');

Route::post('/personalAcademico/{unidad}/buscar', 'PersonalAcademicoController@buscarPersonal')->name('personalAcademico.buscar');
Route::get('/personalAcademico/{unidad}/buscar/{buscando}', 'PersonalAcademicoController@buscarPersonal')->name('personalAcademico.buscando');

Route::get('/archivo/descargar/{nombre}', 'ArchivoController@descargarPorNombre')->name('descargarArchivo');
Route::get('/archivo/eliminar/{nombre}', 'ArchivoController@eliminarDocumentoAdicional')->name('eliminarDocumento');

Route::get('/login', 'Auth\LoginController@showLoginform')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/activar/{token}', 'ActivationTokenController@activate')->name('activation');

Route::get('/reset-password', 'Auth\ResetPasswordController@index')->name('reset-password');
Route::post('/reset-password', 'Auth\ResetPasswordController@reset');

Route::get('/forgot-password', 'Auth\ForgotPasswordController@index')->name('forgot-password');
Route::get('/recover/{token}', 'Auth\ForgotPasswordController@authUser')->name('recover');
Route::post('/forgot-password', 'Auth\ForgotPasswordController@sendEmail');

Route::get('/notificaciones', 'NotificationController@index')->name('notificaciones');
Route::patch('/notificaciones/{id}', 'NotificationController@leer')->name('notificaciones.leer');

Route::get('/llenar', function () {
    if (App\User::count() > 0) return back()->with('info', 'ya hay usuarios en laravel :v');
    $usuarios = App\Usuario::all();
    //dd($usuarios);
    $users = [];
    foreach ($usuarios as $usuario) {
        $user = new App\User;
        $user->name = $usuario->nombre;
        $user->email = $usuario->correo_electronico;
        $user->password = bcrypt($usuario->contrasenia);
        $user->active = true;
        $user->usuario_codSis = $usuario->codSis;
        $user->email_verified_at = Carbon::now();
        $user->save();
        array_push($users, $user);
    }
    return back()->with('success', 'usuarios llenados :3');
});

Route::get('/llenar2', function () {
    if (App\Notificaciones::count() > 0) return back()->with('info', 'ya hay notificaciones en laravel :v');
    for($i = 0; $i < 10; $i++){
        $noti = new App\Notificaciones;
        $noti->user_id = 5;
        $noti->text = 'Notificacion ' . $i;
        $noti->save();
    }
    return redirect('/')->with('success', 'usuarios llenados :3');
});