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

class OldAsistenciaAlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index1()
    {
        if(accesoUser([1,2,3])){

            $iduser=Auth::user()->id;

            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);       
            $imagenPerfil="";
            $modulo="oldasistenciaalumnos";

            $fecha=date("d/m/Y");
            $fecnow=date("Y-m-d");
            $hora=date("H:i:s");

        $diaActual=date("d");
        $mes=date("m");
        $mesActual=intval($mes)-1;
        $yearActual=date("Y");

        $horaActual=date("H");
        $minActual=date("i");
        $secActual=date("s");

            $turnoActivo=Turno::where('activo','1')->where('borrado','0')->where('tipo','2')->where('horaIni','<=',$hora)->where('horaFin','>=',$hora)->limit(1)->get();

            return view('oldasistenciaalumnos.index',compact('modulo','imagenPerfil','tipouser','fecha','hora','turnoActivo','diaActual','mesActual','yearActual','horaActual','minActual','secActual','fecnow'));

        }
            else
        {
            return view('adminlte::home');           
        }
    }

    public function revTurno($id)
    {   
        $hora=date("H:i:s");
        $turnoActivo=Turno::where('activo','1')->where('borrado','0')->where('tipo','2')->where('horaIni','<=',$hora)->where('horaFin','>=',$hora)->limit(1)->get();

        $oldTurno=Turno::findOrFail($id);

        $keyturno='';
        $turno='No hay un turno activo en este momento';
        $horaini='';
        $horafin='';
        $result='0';
        $msj='Turno '.$oldTurno->descripcion.' Desactivado';

        foreach ($turnoActivo as $key => $dato) {
            $keyturno=$dato->id;
            $turno=$dato->descripcion;
            $horaini=$dato->horaIni;
            $horafin=$dato->horaFin;
            $msj='Turno '.$dato->descripcion.' Activado';
            $result='1';
        }

        return [
            'keyturno'=>$keyturno,
            'turno'=>$turno,
            'horaini'=>$horaini,
            'horafin'=>$horafin,
            'result'=>$result,
            'msj'=>$msj
        ];
    }


     public function index(Request $request)
    {
        $iduser=Auth::user()->id;
        $idtipouser=Auth::user()->tipouser_id;
        $tipouser=Tipouser::find($idtipouser);

        $buscar=$request->busca;
        $fecnow=$request->fecnow;

        $institucion="";

            if($idtipouser=="3"){

                $user=User::findOrFail($iduser);
                $persona=Persona::findOrFail($user->persona_id);

                $personal=Personal::where('persona_id',$persona->id)->get();
                $idIE="";
                foreach ($personal as $key => $dato) {
                     $idIE=$dato->institucion_id;
                }

                //$institucion=Institucion::where('id',$idIE)->where('activo','1')->where('borrado','0')->where('tipo','2')->paginate(35);

                $institucion=DB::table('institucions')
                ->join('datoscolegios', 'datoscolegios.institucion_id', '=', 'institucions.id')
                ->join('nivels', 'datoscolegios.nivel_id', '=', 'nivels.id')
                ->join('tipoies', 'datoscolegios.tipoie_id', '=', 'tipoies.id')
                ->join('tipogestions', 'datoscolegios.tipogestion_id', '=', 'tipogestions.id')
                ->where('institucions.activo','1')
                ->where('institucions.borrado','0')
                ->where('institucions.tipo','2')
                ->where('institucions.id',$idIE)
                ->orderBy('institucions.id')
                ->where('institucions.nombre','like','%'.$buscar.'%')
                ->select('institucions.id','institucions.nombre as nombre','institucions.direccion','institucions.telefono','institucions.correo','institucions.activo','datoscolegios.id as idcolegio','datoscolegios.zona','datoscolegios.codigomod','datoscolegios.clave8','datoscolegios.modalidad','nivels.descripcion as nivel','tipoies.descripcion as tipoie','tipogestions.descripcion as tipogestion')->paginate(35);
            }
            else{
               // $institucion=Institucion::where('activo','1')->where('borrado','0')->where('tipo','2')->get()->paginate(35);;
                 $institucion=DB::table('institucions')
                ->join('datoscolegios', 'datoscolegios.institucion_id', '=', 'institucions.id')
                ->join('nivels', 'datoscolegios.nivel_id', '=', 'nivels.id')
                ->join('tipoies', 'datoscolegios.tipoie_id', '=', 'tipoies.id')
                ->join('tipogestions', 'datoscolegios.tipogestion_id', '=', 'tipogestions.id')
                ->where('institucions.activo','1')
                ->where('institucions.borrado','0')
                ->where('institucions.tipo','2')
                ->orderBy('institucions.id')
                ->where('institucions.nombre','like','%'.$buscar.'%')
                ->select('institucions.id','institucions.nombre as nombre','institucions.direccion','institucions.telefono','institucions.correo','institucions.activo','datoscolegios.id as idcolegio','datoscolegios.zona','datoscolegios.codigomod','datoscolegios.clave8','datoscolegios.modalidad','nivels.descripcion as nivel','tipoies.descripcion as tipoie','tipogestions.descripcion as tipogestion')->paginate(35);
            }
            $numAlumnos= array();
            $numTurnos= array();

            $fec="'".$fecnow."'";
            $dia=date("N",strtotime($fec));
            
            $fecha=$fecnow;

            foreach ($institucion as $key => $dato) {

    $cantAlumnos=DB::select("select ifnull(sum(s.cantalumnos),'0') as cant from grados g
    inner join seccions s on s.grado_id=g.id where g.datoscolegio_id='".$dato->idcolegio."' 
    and s.activo='1' and s.borrado='0' and g.activo='1' and g.borrado='0';");

    $cantAsistentes=DB::select("select ifnull(sum(a.cantasist),'0') as cant from asistenciaalumnos a
                inner join seccions s on s.id=a.seccion_id
                inner join grados g on g.id=s.grado_id
                where g.datoscolegio_id='".$dato->idcolegio."' 
                and s.activo='1' and s.borrado='0' and g.activo='1' and g.borrado='0' and a.fecha='".$fecha."';");

        $v1="";
        $v2="";
    foreach ($cantAlumnos as $cant) {
        $v1=$cant->cant;
    }

    foreach ($cantAsistentes as $asistent) {
        $v2=$asistent->cant;
    }
                
                $newobj = new stdClass();
                $newobj->nombre = $dato->nombre;
                $newobj->idInstituto = $dato->id;
                $newobj->idColegio = $dato->idcolegio;
                $newobj->codigomod = $dato->codigomod;
                $newobj->cantidad = $v1;
                $newobj->asistentes = $v2;

                 $numAlumnos[$key]=$newobj;



    $turnosInsti=DB::select("select i.id as idnsti, t.id as idturno, t.descripcion from institucions i
    inner join datoscolegios d on i.id=d.institucion_id
    inner join grados g on g.datoscolegio_id=d.id
    inner join seccions s on s.grado_id=g.id
    inner join configdias c on s.id=c.seccion_id
    inner join turnos t on t.id=c.turno_id
    where i.id='".$dato->id."'  and g.activo='1' and g.borrado='0' and s.activo='1' and s.borrado='0' and c.activo='1' and c.borrado='0'
    group by t.id;");

    $idInsti="";
    $idTurno="";
    $turnos="";

    foreach ($turnosInsti as $turnos) {
        $idInsti=$turnos->idnsti;
        $idTurno=$turnos->idturno;
        $turnos=$turnos->descripcion;

    $newobj2 = new stdClass();
    $newobj2->idInstituto = $idInsti;
    $newobj2->idTurno = $idTurno;
    $newobj2->turnos = $turnos;

     $numTurnos[]= $newobj2;
    }

    


}

$turns=Turno::where('tipo','2')->where('activo','1')->where('borrado','0')->get();


            return [
            'pagination'=>[
                'total'=> $institucion->total(),
                'current_page'=> $institucion->currentPage(),
                'per_page'=> $institucion->perPage(),
                'last_page'=> $institucion->lastPage(),
                'from'=> $institucion->firstItem(),
                'to'=> $institucion->lastItem(),
            ],
            'institucion'=>$institucion,
            'numAlumnos'=>$numAlumnos,
            'turns'=>$turns,
            'numTurnos'=>$numTurnos,
            'fecha'=>$fecha
        ];
    }

    public function abrirIE($id,$fec)
    {
        $result='1';
        $msj='Proceda a Realizar los Registros de Asistencia';
        $selector='';

        $grados=Grado::where('activo','1')->where('borrado','0')->where('datoscolegio_id',$id)->get();

        $fecha=$fec;
        $fec="'".$fecha."'";
        $dia=date("N",strtotime($fecha));
        //$fecha="'".$fecha."'";

        $secciones=DB::table('seccions')
                ->join('grados', 'seccions.grado_id', '=', 'grados.id')
                ->join('datoscolegios', 'datoscolegios.id', '=', 'grados.datoscolegio_id')
                ->join('institucions', 'institucions.id', '=', 'datoscolegios.institucion_id')
                ->join('nivels', 'nivels.id', '=', 'datoscolegios.nivel_id')
                ->join('configdias', 'seccions.id', '=', 'configdias.seccion_id')
                ->join('turnos', 'turnos.id', '=', 'configdias.turno_id')
                ->leftJoin('asistenciaalumnos',  function($join) use ($fec){
                    $join->on('asistenciaalumnos.seccion_id', '=', 'seccions.id');
                    $join->on('asistenciaalumnos.fecha', '=', DB::raw($fec));
                })
                ->where('seccions.activo','1')
                ->where('seccions.borrado','0')
                ->where('grados.activo','1')
                ->where('grados.borrado','0')
                ->where('datoscolegios.id',$id)
                ->where('configdias.tipodia_id',$dia)
                ->where('configdias.borrado','0')
                ->where('configdias.tipo','2')
                ->orderBy('grados.id')
                ->orderBy('seccions.id')

                ->select('seccions.id as idSec','seccions.nombre as seccion','seccions.cantalumnos','grados.id as idgrados','grados.nombre as grado','asistenciaalumnos.cantasist','nivels.descripcion as nivel','configdias.id as idconfig','configdias.activo as activoDia','turnos.id as idturno','turnos.descripcion as turno')->get();



        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector,'grados'=>$grados,'secciones'=>$secciones,'dia'=>$dia]);

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
        $secciones=$request->secciones;
        $keyturno=$request->keyturno;
        $fecha=$request->fecnow;

        /*
        activoDia: 1
cantalumnos: 20
cantasist: "10"
grado: "1° Grado"
idSec: 1
idconfig: 22176
idgrados: 1
idturno: 4
nivel: "A5 - INICIAL PROG NO ESCOLARIZADA"
seccion: "Seccion A"
turno: "MAÑANA"*/

        foreach ($secciones as $key => $dato) {


                $deleterows=Asistenciaalumno::where('seccion_id',$dato['idSec'])->where('fecha',$fecha)->delete(); 

            
            
        }

      foreach ($secciones as $key => $dato) {

            if(strval($dato['activoDia'])=="1"){


            $Asistencia = new Asistenciaalumno();
                $Asistencia->nombre='Asistencia Alumnos'; 
                $Asistencia->cantasist=intval($dato['cantasist']);//Tipo Dia del 1 al 7, esto no es editable 
                $Asistencia->fecha=$fecha;
                $Asistencia->activo='1';
                $Asistencia->borrado='0';
                $Asistencia->canttotal=intval($dato['cantalumnos']);
                $Asistencia->seccion_id=$dato['idSec'];
                $Asistencia->configdia_id=$dato['idconfig'];
            $Asistencia->save();


             }
        }

        $result='1';
        $msj='';
        $selector='';


         $msj='Asistencia de Alumnos Registrada con Éxito';

         return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector,'secciones'=>$secciones]);
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
        //
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
