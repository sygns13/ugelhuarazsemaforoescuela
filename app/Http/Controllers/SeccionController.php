<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Persona;
use App\Personal;
use App\Tipouser;
use App\User;

use App\Turno;
use App\Configdia;
use App\Tipodia;
use App\Institucion;

use App\Datoscolegio;
use App\Nivel;
use App\Tipogestion;
use App\Tipoie;
use App\Grado;
use App\Seccion;
use App\Asistenciaalumno;

use Validator;
use Auth;
use DB;
use Storage;
use stdClass;

class SeccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function key()
    {
        $claves=DB::select("select * from claves;");

        $array=array();

        $html="";

        foreach ($claves as $key => $dato) {
            $html.=bcrypt($dato->clave).'<br>';
        }

        return $html;
    }

    public function store(Request $request)
    {
        $seccion=$request->seccion;
        $cantAlum=$request->cantAlum;
        $estado=$request->estado;
        $newgradID=$request->newgradID;

        $idturno=$request->idturno;

        $check1=$request->check1;
        $check2=$request->check2;
        $check3=$request->check3;
        $check4=$request->check4;
        $check5=$request->check5;
        $check6=$request->check6;
        $check7=$request->check7;


        if(strval($check1)=="true"){
            $check1=1;
        }elseif(strval($check1)=="false"){
            $check1=0;
        }

        if(strval($check2)=="true"){
            $check2=1;
        }elseif(strval($check2)=="false"){
            $check2=0;
        }

        if(strval($check3)=="true"){
            $check3=1;
        }elseif(strval($check3)=="false"){
            $check3=0;
        }

        if(strval($check4)=="true"){
            $check4=1;
        }elseif(strval($check4)=="false"){
            $check4=0;
        }

        if(strval($check5)=="true"){
            $check5=1;
        }elseif(strval($check5)=="false"){
            $check5=0;
        }

        if(strval($check6)=="true"){
            $check6=1;
        }elseif(strval($check6)=="false"){
            $check6=0;
        }

        if(strval($check7)=="true"){
            $check7=1;
        }elseif(strval($check7)=="false"){
            $check7=0;
        }

        if(strlen($cantAlum)==0){
            $cantAlum=0;
        }

        $fecha=date("Y/m/d");

        $input1  = array('seccion' => $seccion);
        $reglas1 = array('seccion' => 'required');

        $validator1 = Validator::make($input1, $reglas1);

        $result='1';
         $msj='';
         $selector='';

         if($validator1->fails()){
            $result='0';
            $msj='Consigne un Nombre de Sección Válido';
            $selector='txtSeccion';
         }

         else{
            $newSeccion = new Seccion();
                $newSeccion->nombre=$seccion; 
                $newSeccion->cantalumnos=$cantAlum; 
                $newSeccion->activo=$estado;
                $newSeccion->borrado='0';
                $newSeccion->grado_id=$newgradID;
                $newSeccion->fechaini=$fecha;
                $newSeccion->fechafin=$fecha;


            $newSeccion->save();


            //Lunes
            $newConfig1 = new Configdia();
                $newConfig1->tipo='2'; 
                $newConfig1->tipodia_id='1';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig1->seccion_id=$newSeccion->id;
                $newConfig1->activo=$check1;
                $newConfig1->borrado='0';
                $newConfig1->fechaini=$fecha;
                $newConfig1->fechafin=$fecha;
                $newConfig1->turno_id=$idturno;
            $newConfig1->save();

            //Martes
            $newConfig2 = new Configdia();
                $newConfig2->tipo='2'; 
                $newConfig2->tipodia_id='2';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig2->seccion_id=$newSeccion->id;
                $newConfig2->activo=$check2;
                $newConfig2->borrado='0';
                $newConfig2->fechaini=$fecha;
                $newConfig2->fechafin=$fecha;
                $newConfig2->turno_id=$idturno;
            $newConfig2->save();

            //Miercoles
            $newConfig3 = new Configdia();
                $newConfig3->tipo='2'; 
                $newConfig3->tipodia_id='3';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig3->seccion_id=$newSeccion->id;
                $newConfig3->activo=$check3;
                $newConfig3->borrado='0';
                $newConfig3->fechaini=$fecha;
                $newConfig3->fechafin=$fecha;
                $newConfig3->turno_id=$idturno;
            $newConfig3->save();

            //Jueves
            $newConfig4 = new Configdia();
                $newConfig4->tipo='2'; 
                $newConfig4->tipodia_id='4';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig4->seccion_id=$newSeccion->id;
                $newConfig4->activo=$check4;
                $newConfig4->borrado='0';
                $newConfig4->fechaini=$fecha;
                $newConfig4->fechafin=$fecha;
                $newConfig4->turno_id=$idturno;
            $newConfig4->save();

            //Viernes
            $newConfig5 = new Configdia();
                $newConfig5->tipo='2'; 
                $newConfig5->tipodia_id='5';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig5->seccion_id=$newSeccion->id;
                $newConfig5->activo=$check5;
                $newConfig5->borrado='0';
                $newConfig5->fechaini=$fecha;
                $newConfig5->fechafin=$fecha;
                $newConfig5->turno_id=$idturno;
            $newConfig5->save();

            //Sabado
            $newConfig6 = new Configdia();
                $newConfig6->tipo='2'; 
                $newConfig6->tipodia_id='6';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig6->seccion_id=$newSeccion->id;
                $newConfig6->activo=$check6;
                $newConfig6->borrado='0';
                $newConfig6->fechaini=$fecha;
                $newConfig6->fechafin=$fecha;
                $newConfig6->turno_id=$idturno;
            $newConfig6->save();

            //Domingo
            $newConfig7 = new Configdia();
                $newConfig7->tipo='2'; 
                $newConfig7->tipodia_id='7';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig7->seccion_id=$newSeccion->id;
                $newConfig7->activo=$check7;
                $newConfig7->borrado='0';
                $newConfig7->fechaini=$fecha;
                $newConfig7->fechafin=$fecha;
                $newConfig7->turno_id=$idturno;
            $newConfig7->save();



            $msj='Nueva Sección creada con éxito';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
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

    public function EditTurnos(Request $request)
    {
        $idSeccion=$request->id;

        $idConfig1=$request->idConfig1;
        $idConfig2=$request->idConfig2;
        $idConfig3=$request->idConfig3;
        $idConfig4=$request->idConfig4;
        $idConfig5=$request->idConfig5;
        $idConfig6=$request->idConfig6;
        $idConfig7=$request->idConfig7;

        $turnoOpE1=$request->turnoOpE1;
        $turnoOpE2=$request->turnoOpE2;
        $turnoOpE3=$request->turnoOpE3;
        $turnoOpE4=$request->turnoOpE4;
        $turnoOpE5=$request->turnoOpE5;
        $turnoOpE6=$request->turnoOpE6;
        $turnoOpE7=$request->turnoOpE7;

        $check1E=$request->check1E;
        $check2E=$request->check2E;
        $check3E=$request->check3E;
        $check4E=$request->check4E;
        $check5E=$request->check5E;
        $check6E=$request->check6E;
        $check7E=$request->check7E;

        if(strval($check1E)=="true"){
            $check1E=1;
        }elseif(strval($check1E)=="false"){
            $check1E=0;
        }

        if(strval($check2E)=="true"){
            $check2E=1;
        }elseif(strval($check2E)=="false"){
            $check2E=0;
        }

        if(strval($check3E)=="true"){
            $check3E=1;
        }elseif(strval($check3E)=="false"){
            $check3E=0;
        }

        if(strval($check4E)=="true"){
            $check4E=1;
        }elseif(strval($check4E)=="false"){
            $check4E=0;
        }

        if(strval($check5E)=="true"){
            $check5E=1;
        }elseif(strval($check5E)=="false"){
            $check5E=0;
        }

        if(strval($check6E)=="true"){
            $check6E=1;
        }elseif(strval($check6E)=="false"){
            $check6E=0;
        }

        if(strval($check7E)=="true"){
            $check7E=1;
        }elseif(strval($check7E)=="false"){
            $check7E=0;
        }

        $fecha=date("Y/m/d");

        $editConfig1 = Configdia::findOrFail($idConfig1);
        $editConfig1->borrado='1';
        $editConfig1->fechafin=$fecha;
        $editConfig1->save();

        $editConfig2 = Configdia::findOrFail($idConfig2);
        $editConfig2->borrado='1';
        $editConfig2->fechafin=$fecha;
        $editConfig2->save();

        $editConfig3 = Configdia::findOrFail($idConfig3);
        $editConfig3->borrado='1';
        $editConfig3->fechafin=$fecha;
        $editConfig3->save();

        $editConfig4 = Configdia::findOrFail($idConfig4);
        $editConfig4->borrado='1';
        $editConfig4->fechafin=$fecha;
        $editConfig4->save();

        $editConfig5 = Configdia::findOrFail($idConfig5);
        $editConfig5->borrado='1';
        $editConfig5->fechafin=$fecha;
        $editConfig5->save();

        $editConfig6 = Configdia::findOrFail($idConfig6);
        $editConfig6->borrado='1';
        $editConfig6->fechafin=$fecha;
        $editConfig6->save();

        $editConfig7 = Configdia::findOrFail($idConfig7);
        $editConfig7->borrado='1';
        $editConfig7->fechafin=$fecha;
        $editConfig7->save();




         //Lunes
            $newConfig1 = new Configdia();
                $newConfig1->tipo='2'; 
                $newConfig1->tipodia_id='1';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig1->seccion_id=$idSeccion;
                $newConfig1->activo=$check1E;
                $newConfig1->borrado='0';
                $newConfig1->fechaini=$fecha;
                $newConfig1->fechafin=$fecha;
                $newConfig1->turno_id=$turnoOpE1;
            $newConfig1->save();

            //Martes
            $newConfig2 = new Configdia();
                $newConfig2->tipo='2'; 
                $newConfig2->tipodia_id='2';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig2->seccion_id=$idSeccion;
                $newConfig2->activo=$check2E;
                $newConfig2->borrado='0';
                $newConfig2->fechaini=$fecha;
                $newConfig2->fechafin=$fecha;
                $newConfig2->turno_id=$turnoOpE2;
            $newConfig2->save();

            //Miercoles
            $newConfig3 = new Configdia();
                $newConfig3->tipo='2'; 
                $newConfig3->tipodia_id='3';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig3->seccion_id=$idSeccion;
                $newConfig3->activo=$check3E;
                $newConfig3->borrado='0';
                $newConfig3->fechaini=$fecha;
                $newConfig3->fechafin=$fecha;
                $newConfig3->turno_id=$turnoOpE3;
            $newConfig3->save();

            //Jueves
            $newConfig4 = new Configdia();
                $newConfig4->tipo='2'; 
                $newConfig4->tipodia_id='4';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig4->seccion_id=$idSeccion;
                $newConfig4->activo=$check4E;
                $newConfig4->borrado='0';
                $newConfig4->fechaini=$fecha;
                $newConfig4->fechafin=$fecha;
                $newConfig4->turno_id=$turnoOpE4;
            $newConfig4->save();

            //Viernes
            $newConfig5 = new Configdia();
                $newConfig5->tipo='2'; 
                $newConfig5->tipodia_id='5';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig5->seccion_id=$idSeccion;
                $newConfig5->activo=$check5E;
                $newConfig5->borrado='0';
                $newConfig5->fechaini=$fecha;
                $newConfig5->fechafin=$fecha;
                $newConfig5->turno_id=$turnoOpE5;
            $newConfig5->save();

            //Sabado
            $newConfig6 = new Configdia();
                $newConfig6->tipo='2'; 
                $newConfig6->tipodia_id='6';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig6->seccion_id=$idSeccion;
                $newConfig6->activo=$check6E;
                $newConfig6->borrado='0';
                $newConfig6->fechaini=$fecha;
                $newConfig6->fechafin=$fecha;
                $newConfig6->turno_id=$turnoOpE6;
            $newConfig6->save();

            //Domingo
            $newConfig7 = new Configdia();
                $newConfig7->tipo='2'; 
                $newConfig7->tipodia_id='7';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig7->seccion_id=$idSeccion;
                $newConfig7->activo=$check7E;
                $newConfig7->borrado='0';
                $newConfig7->fechaini=$fecha;
                $newConfig7->fechafin=$fecha;
                $newConfig7->turno_id=$turnoOpE7;
            $newConfig7->save();

            $result='1';
         $msj='Modificación de Turnos Realizada con Éxito';
         $selector='';

            return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);


    }
    public function update(Request $request, $id)
    {
        $idSeccion=$request->id;
        $seccion=$request->seccion;
        $cantalumnos=$request->cantalumnos;
        $estado=$request->estado;

        if(strlen($cantalumnos)==0){
            $cantalumnos=0;
        }

        $fecha=date("Y/m/d");

        $input1  = array('seccion' => $seccion);
        $reglas1 = array('seccion' => 'required');

        $validator1 = Validator::make($input1, $reglas1);

        $result='1';
         $msj='';
         $selector='';

         if($validator1->fails()){
            $result='0';
            $msj='Consigne una Sección Válido';
            $selector='txtSeccionE';
         }

         else{
            $editSeccion = Seccion::findOrFail($id);
                $editSeccion->nombre=$seccion; 
                $editSeccion->cantalumnos=$cantalumnos; 
                $editSeccion->activo=$estado;

            $editSeccion->save();

            $msj='Sección modificada con éxito';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

     public function altabaja($id,$estado)
    {
        $result='1';
        $msj='';
        $selector='';

        $updateSeccion = Seccion::findOrFail($id);
        $updateSeccion->activo=$estado;
        $updateSeccion->save();

        if(strval($estado)=="0"){
            $msj='La Sección fue Desactivado exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='La Sección fue Activado exitosamente';
        }

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
        $result='1';
        $msj='1';

        $borrarSeccion = Seccion::findOrFail($id);
        $borrarSeccion->borrado='1';
        $borrarSeccion->save();



        $msj='Seccion eliminado exitosamente';
        

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
