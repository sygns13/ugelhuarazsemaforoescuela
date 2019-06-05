<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Persona;
use App\Personal;
use App\Tipouser;
use App\User;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {   
        $iduser=Auth::user()->id;

        $numuser=User::where('id',$iduser)->where('activo','1')->where('borrado','0')->count();

        $personal="";
        if($numuser==1){

            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);



                $persona=DB::table('personas')
        ->join('users', 'users.persona_id', '=', 'personas.id')
        ->join('tipousers','tipousers.id','=','users.tipouser_id')
        ->where('users.borrado','0')
        ->where('users.id',$iduser)
        ->select('personas.id as idper', 'personas.doc', 'personas.nombres as nombresPer', 'personas.apellidos as apePer', 'personas.genero', 'personas.telefono', 'personas.direccion', 'personas.tipodoc', 'users.id as idUsser', 'users.name as username', 'users.email','users.activo as activouser','tipousers.nombre as tipouser')->get();

            $imagenPerfil="";
            $perid="";
            foreach ($persona as $key => $dato) {
                //$imagenPerfil=$dato->imagen;
                $perid=$dato->idper;
            }

            $personal=Personal::where('persona_id',$perid)->get();

                return view('adminlte::home',compact('tipouser','imagenPerfil'));
        }       
        else{
            Auth::logout();

          return redirect()->back()
            ->withErrors([
                'email' => 'usuarioActiv'
            ]);
        }
    }

    
}