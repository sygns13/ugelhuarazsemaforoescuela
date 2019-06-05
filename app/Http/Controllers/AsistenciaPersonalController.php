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
use App\Asistenciapersonal;

use Validator;
use Auth;
use DB;
use Storage;
use stdClass;


class AsistenciaPersonalController extends Controller
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
            $modulo="asistenciapersonal";

            $fecha=date("d/m/Y");
            $hora=date("H:i:s");

        $diaActual=date("d");
        $mes=date("m");
        $mesActual=intval($mes)-1;
        $yearActual=date("Y");

        $horaActual=date("H");
        $minActual=date("i");
        $secActual=date("s");

           $turnoActivo=Turno::where('activo','1')->where('borrado','0')->where('tipo','1')->where('horaIni','<=',$hora)->where('horaFin','>=',$hora)->limit(1)->get();

            return view('asistenciapersonal.index',compact('modulo','imagenPerfil','tipouser','fecha','hora','turnoActivo','diaActual','mesActual','yearActual','horaActual','minActual','secActual'));

        }
            else
        {
            return view('adminlte::home');           
        }
    }

    public function revTurno($id)
    {   
        $hora=date("H:i:s");
        $turnoActivo=Turno::where('activo','1')->where('borrado','0')->where('tipo','1')->where('horaIni','<=',$hora)->where('horaFin','>=',$hora)->limit(1)->get();

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
                ->leftJoin('datoscolegios', 'datoscolegios.institucion_id', '=', 'institucions.id')
                ->leftJoin('nivels', 'datoscolegios.nivel_id', '=', 'nivels.id')
                ->leftJoin('tipoies', 'datoscolegios.tipoie_id', '=', 'tipoies.id')
                ->leftJoin('tipogestions', 'datoscolegios.tipogestion_id', '=', 'tipogestions.id')
                ->where('institucions.activo','1')
                ->where('institucions.borrado','0')
                ->where('institucions.id',$idIE)
                ->where('institucions.nombre','like','%'.$buscar.'%')
                ->select('institucions.id','institucions.nombre as nombre','institucions.direccion','institucions.telefono','institucions.correo','institucions.activo','datoscolegios.id as idcolegio','datoscolegios.zona','datoscolegios.codigomod','datoscolegios.clave8','datoscolegios.modalidad','nivels.descripcion as nivel','tipoies.descripcion as tipoie','tipogestions.descripcion as tipogestion','institucions.tipo as tipoInsti')->paginate(35);
            }
            else{
               // $institucion=Institucion::where('activo','1')->where('borrado','0')->where('tipo','2')->get()->paginate(35);;
                 $institucion=DB::table('institucions')
                ->leftJoin('datoscolegios', 'datoscolegios.institucion_id', '=', 'institucions.id')
                ->leftJoin('nivels', 'datoscolegios.nivel_id', '=', 'nivels.id')
                ->leftJoin('tipoies', 'datoscolegios.tipoie_id', '=', 'tipoies.id')
                ->leftJoin('tipogestions', 'datoscolegios.tipogestion_id', '=', 'tipogestions.id')
                ->where('institucions.activo','1')
                ->where('institucions.borrado','0')
                ->where('institucions.nombre','like','%'.$buscar.'%')
                ->select('institucions.id','institucions.nombre as nombre','institucions.direccion','institucions.telefono','institucions.correo','institucions.activo','datoscolegios.id as idcolegio','datoscolegios.zona','datoscolegios.codigomod','datoscolegios.clave8','datoscolegios.modalidad','nivels.descripcion as nivel','tipoies.descripcion as tipoie','tipogestions.descripcion as tipogestion','institucions.tipo as tipoInsti')->paginate(35);
            }
            $numPersonal= array();
            $numTurnos= array();
            $dia=date("N");
            
            $fecha=date("Y-m-d");
            foreach ($institucion as $key => $dato) {

    $cantpersonal=DB::select("select ifnull(count(c.id),'0') as cant from personals p
inner join institucions i on i.id=p.institucion_id
inner join configdias c on p.id=c.personal_id
where i.id='".$dato->id."' and p.activo='1' and p.borrado='0' and i.activo='1' and i.borrado='0' and c.activo>0 and c.borrado='0' and c.tipodia_id='".$dia."';");

    $cantAsistentes=DB::select("select ifnull(count(a.id),'0') as cant from asistenciapersonals a
inner join personals p on p.id=a.personal_id
inner join institucions i on i.id=p.institucion_id
where i.id='".$dato->id."'
and p.activo='1' and p.borrado='0' and i.activo='1' and i.borrado='0' and a.tipo='1' and a.fecha='".$fecha."';");

        $v1="";
        $v2="";
    foreach ($cantpersonal as $cant) {
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

                 $numPersonal[$key]=$newobj;



                 $turnosInsti=DB::select("select i.id as idnsti, t.id as idturno, t.descripcion from institucions i
inner join personals p on p.institucion_id=i.id
inner join configdias c on p.id=c.personal_id
inner join turnos t on t.id=c.turno_id
where i.id='".$dato->id."'  and p.activo='1' and p.borrado='0'  and c.activo='1' and c.borrado='0'
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

$turns=Turno::where('tipo','1')->where('activo','1')->where('borrado','0')->get();


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
            'numPersonal'=>$numPersonal,
            'turns'=>$turns,
            'numTurnos'=>$numTurnos
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function abrirIE($id,$estado)
    {
        $result='1';
        $msj='Proceda a Realizar los Registros de Asistencia';
        $selector='';

        //$grados=Grado::where('activo','1')->where('borrado','0')->where('datoscolegio_id',$id)->get();

        $fecha=date("Y/m/d");
        $fec="'".$fecha."'";
        $dia=date("N");
        //$fecha="'".$fecha."'";

       /* $secciones=DB::table('seccions')
                ->join('grados', 'seccions.grado_id', '=', 'grados.id')
                ->join('datoscolegios', 'datoscolegios.id', '=', 'grados.datoscolegio_id')
                ->join('nivels', 'nivels.id', '=', 'datoscolegios.nivel_id')
                ->leftJoin('asistenciaalumnos',  function($join) use ($fecha){
                    $join->on('asistenciaalumnos.seccion_id', '=', 'seccions.id');
                    $join->on('asistenciaalumnos.fecha', '=', DB::raw($fecha));
                })
                ->where('seccions.activo','1')
                ->where('seccions.borrado','0')
                ->where('grados.activo','1')
                ->where('grados.borrado','0')

                ->select('seccions.id as idSec','seccions.nombre as seccion','seccions.cantalumnos','grados.id as idgrados','grados.nombre as grado','asistenciaalumnos.cantasist','nivels.descripcion as nivel')->get();*/

       // $personals=Personal::where('activo','1')->where('borrado','0')->where('institucion_id',$id)->get()
        $personals=DB::table('personals')
         ->join('personas', 'personals.persona_id', '=', 'personas.id')
         ->join('configdias', 'personals.id', '=', 'configdias.personal_id')
         ->join('turnos', 'turnos.id', '=', 'configdias.turno_id')
         ->leftJoin('asistenciapersonals',  function($join) use ($fec){
                    $join->on('asistenciapersonals.personal_id', '=', 'personals.id');
                    $join->on('asistenciapersonals.configdia_id', '=', 'configdias.id');
                    $join->on('asistenciapersonals.fecha', '=', DB::raw($fec));
                })
        ->where('personals.activo','1')
        ->where('personals.borrado','0')
        ->where('personals.institucion_id',$id)
        ->where('configdias.tipodia_id',$dia)
        ->where('configdias.borrado','0')
        ->where('configdias.tipo','1')
        ->orderBy('personas.apellidos')
        ->orderBy('personas.nombres')
        ->orderBy('turnos.id')

        ->select('personals.id as idpersonal','personals.ley','personals.cargo','personas.doc','personas.nombres','personas.apellidos','personas.genero','personas.telefono','personas.direccion', 'asistenciapersonals.id as idAsist','asistenciapersonals.asistencia as asistencia','configdias.id as idconfig','configdias.activo as activoDia','turnos.id as idturno','turnos.descripcion as turno')->get();

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector,'personals'=>$personals]);

    }
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
         $personals=$request->personals;
        $keyturno=$request->keyturno;
        $fecha=date("Y/m/d");

        /*
activoDia: 1
apellidos: "ALBA SANCHEZ"
asistencia: null
cargo: "PERSONAL DE VIGILANCIA"
direccion: null
doc: "43804627"
genero: 0
idAsist: null
idconfig: 22330
idpersonal: 6296
idturno: 3
ley: "D. LEG. Nº 1057"
nombres: "RUTER ALEXANDER"
telefono: null
turno: "NOCHE"

*/



        foreach ($personals as $key => $dato) {


            if(intval($keyturno)==intval($dato['idturno'])){
                $deleterows=Asistenciapersonal::where('personal_id',$dato['idpersonal'])->where('fecha',$fecha)->where('configdia_id',$dato['idconfig'])->delete(); 
            }
            
            
        }

      foreach ($personals as $key => $dato) {

        $check1=$dato['asistencia'];

        if(strval($check1)=="true" || strval($check1)=="1"){
            $check1=1;
        }else{
            $check1=0;
        }

            if(strval($dato['activoDia'])=="1" || strval($dato['activoDia'])=="2" || strval($dato['activoDia'])=="3"){

                if(intval($keyturno)==intval($dato['idturno'])){
            $Asistencia = new Asistenciapersonal();
                $Asistencia->nombre='Asistencia Personal'; 
                $Asistencia->asistencia=$check1;//Tipo Dia del 1 al 7, esto no es editable 
                $Asistencia->fecha=$fecha;
                $Asistencia->activo='1';
                $Asistencia->borrado='0';
                $Asistencia->tipo=$check1;
                $Asistencia->personal_id=$dato['idpersonal'];
                $Asistencia->configdia_id=$dato['idconfig'];
            $Asistencia->save();

                 }
             }
        }

        $result='1';
        $msj='';
        $selector='';


         $msj='Asistencia de Personal Registrado con Éxito';

         return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector,'personals'=>$personals]);
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
