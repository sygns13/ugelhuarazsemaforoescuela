<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Persona;
use App\Personal;
use App\Tipouser;
use App\User;

use App\Turno;
use App\Configdia;
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

class GradoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $result='1';
        $msj='Gestión de Institución Educativa';
        $selector='';

        $iduser=Auth::user()->id;
        $idtipouser=Auth::user()->tipouser_id;
        $tipouser=Tipouser::find($idtipouser);

        $buscar=$request->busca;
        $id=$request->idcoleg;

         $grados=Grado::where('borrado','0')->where('datoscolegio_id',$id)->get();

        //$fecha=date("Y/m/d");
        //$fecha="'".$fecha."'";

        $secciones=DB::table('seccions')
                ->join('grados', 'seccions.grado_id', '=', 'grados.id')
                ->join('datoscolegios', 'datoscolegios.id', '=', 'grados.datoscolegio_id')
                ->join('nivels', 'nivels.id', '=', 'datoscolegios.nivel_id')
                ->where('seccions.borrado','0')
                ->where('grados.borrado','0')
                ->where('grados.datoscolegio_id',$id)

                ->select('seccions.id as idSec','seccions.nombre as seccion','seccions.cantalumnos','grados.id as idgrados','grados.nombre as grado','nivels.descripcion as nivel','seccions.activo')->get();

        /*$turnos=DB::table('configdias')
            ->join('grados', 'seccions.grado_id', '=', 'grados.id')*/

    $numAlumnos= array();

    foreach ($grados as $key => $dato) {
        $sec=Seccion::where('activo','1')->where('borrado','0')->where('grado_id',$dato->id)->get();
        $cantAl=0;
        foreach ($sec as $dato2) {
             $cantAl= $cantAl+intval($dato2->cantalumnos);
        }
        $newobj = new stdClass();
                $newobj->idgrado = $dato->id;
                $newobj->cantAl = $cantAl;
        $numAlumnos[$key]=$newobj;
    }


        $turnos=DB::table('configdias')
            ->join('seccions', 'seccions.id', '=', 'configdias.seccion_id')
            ->join('turnos', 'turnos.id', '=', 'configdias.turno_id')
            ->join('tipodias', 'tipodias.id', '=', 'configdias.tipodia_id')
            ->join('grados', 'grados.id', '=', 'seccions.grado_id')
            ->where('grados.datoscolegio_id',$id)
            ->where('configdias.borrado','0')
            ->where('grados.borrado','0')
            ->where('seccions.borrado','0')
            ->orderBy('grados.id')
            ->orderBy('seccions.id')
            ->orderBy('tipodias.id')
         ->select('configdias.id as idconfig','configdias.activo as activo','configdias.fechaini as fechaini','configdias.fechafin as fechafin','seccions.id as idSec','turnos.id as idturnos','turnos.id as idturnos','turnos.id as idturnos','turnos.descripcion as turno','turnos.codigo as codturno','turnos.horaIni','turnos.horaFin','tipodias.id as iddia','tipodias.dia','tipodias.numdia')->get();


         $turns=Turno::where('tipo','2')->where('activo','1')->where('borrado','0')->get();



     return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector,'grados'=>$grados,'secciones'=>$secciones,'numAlumnos'=>$numAlumnos,'turnos'=>$turnos,'turns'=>$turns]);
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
        $grado=$request->grado;
        $estado=$request->estado;
        $colegio_id=$request->colegio_id;

        $input1  = array('grado' => $grado);
        $reglas1 = array('grado' => 'required');

        $validator1 = Validator::make($input1, $reglas1);

        $result='1';
         $msj='';
         $selector='';

         if($validator1->fails()){
            $result='0';
            $msj='Consigne un Grado Válido';
            $selector='txtgrado';
         }

         else{
            $newGrado = new Grado();
                $newGrado->nombre=$grado; 
                $newGrado->activo=$estado;
                $newGrado->borrado='0';
                $newGrado->datoscolegio_id=$colegio_id;


            $newGrado->save();



            $msj='Nuevo Grado creado con éxito';
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
    public function update(Request $request, $id)
    {
        $idgrado=$request->id;
        $grado=$request->grado;
        $estado=$request->estado;

        $input1  = array('grado' => $grado);
        $reglas1 = array('grado' => 'required');

        $validator1 = Validator::make($input1, $reglas1);

        $result='1';
         $msj='';
         $selector='';

         if($validator1->fails()){
            $result='0';
            $msj='Consigne un Grado Válido';
            $selector='txtgradoE';
         }

         else{
            $editGrado = Grado::findOrFail($id);
                $editGrado->nombre=$grado; 
                $editGrado->activo=$estado;

            $editGrado->save();

            $msj='Grado modificado con éxito';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    public function altabaja($id,$estado)
    {
        $result='1';
        $msj='';
        $selector='';

        $updateGrado = Grado::findOrFail($id);
        $updateGrado->activo=$estado;
        $updateGrado->save();

        if(strval($estado)=="0"){
            $msj='El Grado fue Desactivado exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='El Grado fue Activado exitosamente';
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



        $borrarGrado = Grado::findOrFail($id);
        $borrarGrado->borrado='1';
        $borrarGrado->save();



        $msj='Grado eliminado exitosamente';
        

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
