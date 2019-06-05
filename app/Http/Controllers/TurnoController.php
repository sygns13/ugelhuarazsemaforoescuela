<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Persona;
use App\Personal;
use App\Tipouser;
use App\User;

use App\Turno;

use Validator;
use Auth;
use DB;
use Storage;
use stdClass;


class TurnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index1()
    {
        if(accesoUser([1,2])){

            $modulo="mainTurnos";
            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);       
            $imagenPerfil="";

            return view('turnos.index',compact('modulo','imagenPerfil','tipouser'));
        }
        else
        {
            return view('adminlte::home');           
        }
    }

    public function index()
    {
        $turnos1=Turno::where('activo','1')->where('borrado','0')->where('tipo','1')->get();

        $turnos2=Turno::where('activo','1')->where('borrado','0')->where('tipo','2')->get();

        return [
            'turnos1'=>$turnos1,
            'turnos2'=>$turnos2
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $idTurno=$request->id;
        $horaIni=$request->horaIni;
        $horaFin=$request->horaFin;

        $input1  = array('horaIni' => $horaIni);
        $reglas1 = array('horaIni' => 'required');


        $input2  = array('horaFin' => $horaFin);
        $reglas2 = array('horaFin' => 'required');


         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);

         $result='1';
         $msj='';
         $selector='';

         if ($validator1->fails())
        {
            $result='0';
            $msj='Debe Ingresar la Hora Inicial de Registro de Asistencia';
            $selector='hraIni';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Debe Ingresar la Hora Final de Registro de Asistencia';
            $selector='hraFin';
        }
        else{
            $updateTurno = Turno::findOrFail($id);
                $updateTurno->horaIni=$horaIni;
                $updateTurno->horaFin=$horaFin;
            $updateTurno->save();

            $msj='El Turno ha sido Modificado Exitosamente.';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
