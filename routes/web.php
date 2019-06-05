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
    //return view('welcome');
    return redirect('login');
});

Route::group(['middleware' => 'auth'], function () {
    //    Route::get('/link1', function ()    {
//        // Uses Auth Middleware
//    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes


    Route::get('asistAlumnos','AsistenciaAlumnoController@index1');
    Route::get('asistPersonal','AsistenciaPersonalController@index1');
    Route::get('datosugel','UgelController@index1');
    Route::get('ies','ColegiosController@index1');
    Route::get('turnos','TurnoController@index1');
    Route::get('usuarios','UserController@index1');
    Route::get('personal','PersonalController@index1');
    Route::get('feriados','FeriadoController@index1');

    Route::get('repAsistenciaAlumnosMasiva','ReporteAlumnosController@index1');
    Route::get('repAsistenciaPersonalMasiva','ReportePersonalController@index1');
    Route::get('replicencia','LicenciaController@index1');

    Route::get('rectiAlumnos','OldAsistenciaAlumnoController@index1');
    Route::get('rectiPersonal','OldAsistenciaPersonalController@index1');



    Route::resource('AsistenciaAlumnos','AsistenciaAlumnoController');
    Route::resource('AsistenciaPersonal','AsistenciaPersonalController');
    Route::resource('ugel','UgelController');
    Route::resource('colegios','ColegiosController');
    Route::resource('grados','GradoController');
    Route::resource('seccion','SeccionController');
    Route::resource('turno','TurnoController');
    Route::resource('usuario','UserController');
    Route::resource('personals','PersonalController');
    Route::resource('justificacion','JustificacionController');


    Route::resource('OldAsistenciaAlumnos','OldAsistenciaAlumnoController');
    Route::resource('OldAsistenciaPersonal','OldAsistenciaPersonalController');
    

    Route::resource('feriado','FeriadoController');

    Route::resource('repAlumnos','ReporteAlumnosController');
    Route::get('repAlumnos/getGrados/{id}','ReporteAlumnosController@getGrados');
    Route::get('repAlumnos/getSeccions/{id}','ReporteAlumnosController@getSeccions');
    Route::post('repAlumnos/buscar','ReporteAlumnosController@buscar');
    Route::post('repAlumnos/buscar2','ReporteAlumnosController@buscar2');
    Route::post('repAlumnos/buscar3','ReporteAlumnosController@buscar3');


    Route::resource('repPersonal','ReportePersonalController');
    Route::get('repPersonal/getPersonal/{id}','ReportePersonalController@getPersonal');
    Route::post('repPersonal/buscar','ReportePersonalController@buscar');
    Route::post('repPersonal/buscar2','ReportePersonalController@buscar2');
    Route::post('repPersonal/buscar3','ReportePersonalController@buscar3');
    Route::post('repPersonal/buscar4','ReportePersonalController@buscar4');

    Route::resource('reporteLicencia','LicenciaController');
    Route::get('reporteLicencia/getPersonal/{id}','LicenciaController@getPersonal');
    Route::post('reporteLicencia/buscar','LicenciaController@buscar');


    Route::get('AsistenciaAlumnos/abrirIE/{id}/{var}','AsistenciaAlumnoController@abrirIE');
    Route::get('AsistenciaAlumnos/revTurno/{id}','AsistenciaAlumnoController@revTurno');
    
    Route::get('AsistenciaPersonal/abrirIE/{id}/{var}','AsistenciaPersonalController@abrirIE');
    Route::get('AsistenciaPersonal/revTurno/{id}','AsistenciaPersonalController@revTurno');

    Route::get('colegios/altabaja/{id}/{var}','ColegiosController@altabaja');
    Route::get('grados/altabaja/{id}/{var}','GradoController@altabaja');
    Route::get('seccion/altabaja/{id}/{var}','SeccionController@altabaja');
    Route::get('usuario/verpersona/{dni}','UserController@verpersona');
    Route::get('usuario/altabaja/{id}/{var}','UserController@altabaja');
    Route::get('personals/verpersona/{dni}','PersonalController@verpersona');
    Route::get('personals/altabaja/{id}/{var}','PersonalController@altabaja');
    Route::get('feriado/altabaja/{id}/{var}','FeriadoController@altabaja');


    Route::post('seccion/EditTurnos','SeccionController@EditTurnos');
    Route::post('personals/EditTurnos','PersonalController@EditTurnos');
    Route::post('personals/EditTurnos','PersonalController@EditTurnos');




    Route::get('OldAsistenciaAlumnos/abrirIE/{id}/{var}','OldAsistenciaAlumnoController@abrirIE');
    Route::get('OldAsistenciaAlumnos/revTurno/{id}','OldAsistenciaAlumnoController@revTurno');
    
    Route::get('OldAsistenciaPersonal/abrirIE/{id}/{var}','OldAsistenciaPersonalController@abrirIE');
    Route::get('OldAsistenciaPersonal/revTurno/{id}','OldAsistenciaPersonalController@revTurno');



        Route::get('usuario/altabajaOld/{id}/{var}','UserController@altabajaOld');

    

    /*
Route::get('areasUNASAM','AreaunasamController@index1');
Route::get('ciclos','CicloController@index1');
Route::get('facultades','FacultadController@index1');
Route::get('carrerasUNASAM','CarreraunasamController@index1');
Route::get('alumnos','AlumnoController@index1');
Route::get('usuarios','UserController@index1');
Route::get('inventarioInteresesProfesionales','MetodologiavocacionalController@index1');
Route::get('kuder','MetodologiavocacionalController@index2');

Route::get('campoprofesionalippr/{idmetodologia}','CampoprofesionalController@index1');
Route::get('maestrocarreras/{idCampoProfs}','MaestrocarreraController@index1');

Route::get('campoprofesionalkuder/{idmetodologia}','CampoprofesionalController@index2');
Route::get('maestrocarreras2/{idCampoProfs}','MaestrocarreraController@index2');

Route::get('preguntasippr/{idModulo}','PreguntaController@index1');
Route::get('preguntaskuder/{idModulo}','PreguntaController@index2');



Route::resource('areas','AreaunasamController');
Route::resource('ciclo','CicloController');
Route::resource('facultad','FacultadController');
Route::resource('carreraunasam','CarreraunasamController');
Route::resource('informacion','InformacionController');
Route::resource('alumno','AlumnoController');
Route::resource('usuario','UserController');
Route::resource('metodologia','MetodologiavocacionalController');
Route::resource('modulo','ModulovocacionalController');
Route::resource('validez','ValidezController');
Route::resource('regla','ReglaController');
Route::resource('campoProfesional','CampoprofesionalController');
Route::resource('maestrocarrera','MaestrocarreraController');
Route::resource('pregunta','PreguntaController');
Route::resource('alternativa','AlternativaController');
Route::resource('preguntakuder','PreguntakuderController');
Route::resource('alternativakuder','AlternativakuderController');


Route::get('areas/altabaja/{id}/{var}','AreaunasamController@altabaja');
Route::get('ciclo/activar/{id}/{var}','CicloController@activar');
Route::get('facultad/altabaja/{id}/{var}','FacultadController@altabaja');
Route::get('carreraunasam/altabaja/{id}/{var}','CarreraunasamController@altabaja');
Route::get('informacion/altabaja/{id}/{var}','InformacionController@altabaja');
Route::get('informacion/deleteImg/{id}/{var}','InformacionController@deleteImg');
Route::get('informacion/deleteFile/{id}/{var}','InformacionController@deleteFile');
Route::get('informacion/cambiarAdj/{id}/{var}','InformacionController@cambiarAdj');
Route::post('informacion/editar','InformacionController@editar');
Route::get('alumno/verpersona/{dni}','AlumnoController@verpersona');
Route::get('alumno/altabaja/{id}/{var}','AlumnoController@altabaja');
Route::get('usuario/verpersona/{dni}','UserController@verpersona');
Route::get('usuario/altabaja/{id}/{var}','UserController@altabaja');
Route::get('campoProfesional/altabaja/{id}/{var}','CampoprofesionalController@altabaja');
Route::get('maestrocarrera/altabaja/{id}/{var}','MaestrocarreraController@altabaja');
Route::get('pregunta/altabaja/{id}/{var}','PreguntaController@altabaja');
Route::get('preguntakuder/altabaja/{id}/{var}','PreguntakuderController@altabaja');

//Impresiones IPP
Route::get('plantilla/imprimir/{id}/{id2}','PreguntaController@imprimirPlantilla');
Route::get('hoja/imprimir/{id}/{id2}','PreguntaController@imprimirHoja');
Route::get('plantilla/datos','PreguntaController@getDatos');


//Impresiones KUDER
Route::get('plantillakuder/imprimir/{id}/{id2}','PreguntakuderController@imprimirPlantilla');
Route::get('hojakuder/imprimir/{id}/{id2}','PreguntakuderController@imprimirHoja');
Route::get('plantillakuder/datos','PreguntakuderController@getDatos');




//Rutas Alumno
Route::get('alumnoDatos','AlumnoController@alumnoDatos');

Route::get('testIPP','TestController@index1');

Route::resource('test','TestController');
Route::resource('respuesta','DetallerespuestaController');

Route::get('testKUDER','TestController@index2');
Route::post('respuestakuder','DetallerespuestaController@respuestakuder');
*/

});
