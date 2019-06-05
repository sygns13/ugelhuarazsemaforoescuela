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

use App\Feriado;

use Validator;
use Auth;
use DB;
use Storage;
use stdClass;
use DateTime;

set_time_limit(600);


class ReporteAlumnosController extends Controller
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
            $modulo="repAsistenciaAlumnos";

              $fecha=date("d/m/Y");
            $mesActual=date("m");
        $yearActual=date("Y");



            return view('reporteAlumnos.index',compact('modulo','imagenPerfil','tipouser','mesActual','yearActual','fecha'));

        }
            else
        {
            return view('adminlte::home');           
        }
    }


    public function index()
    {
        $institucion="";
                $iduser=Auth::user()->id;
        $idtipouser=Auth::user()->tipouser_id;
        $tipouser=Tipouser::find($idtipouser);

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

                ->select('institucions.id','institucions.nombre as nombre','institucions.direccion','institucions.telefono','institucions.correo','institucions.activo','institucions.tipo','datoscolegios.id as idcolegio','datoscolegios.zona','datoscolegios.codigomod','datoscolegios.clave8','datoscolegios.modalidad','nivels.descripcion as nivel','tipoies.descripcion as tipoie','tipogestions.descripcion as tipogestion')->get();
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

                ->select('institucions.id','institucions.nombre as nombre','institucions.direccion','institucions.telefono','institucions.correo','institucions.activo','institucions.tipo','datoscolegios.id as idcolegio','datoscolegios.zona','datoscolegios.codigomod','datoscolegios.clave8','datoscolegios.modalidad','nivels.descripcion as nivel','tipoies.descripcion as tipoie','tipogestions.descripcion as tipogestion')->get();
            }


            return [

            'institucions'=>$institucion
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function buscar(Request $request)
    {
        $idColegio=$request->idColegio;
        $idGrados=$request->idGrados;
        $idSeccions=$request->idSeccions;

        $tipofecha=$request->tipofecha;
        $fechaini=$request->fechaini;
        $fechafin=$request->fechafin;



         $institucion="";
                $iduser=Auth::user()->id;
        $idtipouser=Auth::user()->tipouser_id;
        $tipouser=Tipouser::find($idtipouser);

            if($idtipouser=="3" || intval($idColegio)>0){

                $user=User::findOrFail($iduser);
                $persona=Persona::findOrFail($user->persona_id);

                $personal=Personal::where('persona_id',$persona->id)->where('activo','>','0')->get();
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

                ->select('institucions.id','institucions.nombre as nombre','institucions.direccion','institucions.telefono','institucions.correo','institucions.activo','institucions.tipo','datoscolegios.id as idcolegio','datoscolegios.zona','datoscolegios.codigomod','datoscolegios.clave8','datoscolegios.modalidad','nivels.descripcion as nivel','tipoies.descripcion as tipoie','tipogestions.descripcion as tipogestion')->get();
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

                ->select('institucions.id','institucions.nombre as nombre','institucions.direccion','institucions.telefono','institucions.correo','institucions.activo','institucions.tipo','datoscolegios.id as idcolegio','datoscolegios.zona','datoscolegios.codigomod','datoscolegios.clave8','datoscolegios.modalidad','nivels.descripcion as nivel','tipoies.descripcion as tipoie','tipogestions.descripcion as tipogestion')->get();
            }

            $fecha=date("Y-m-d");
                $fechnow=date("Y-m-d");
        $v1=0;
        $v2=0;
        $v3=0;
        $v4=0;

          $tipofecha=$request->tipofecha;
        $fechaini=$request->fechaini;
        $fechafin=$request->fechafin;

        if($tipofecha==0){
            $fechaini=date("Y-m-d");
            $fechafin=date("Y-m-d");
        }elseif ($tipofecha==1) {


            $month = date('m');
            $year = date('Y');
            $day = date("d", mktime(0,0,0, $month+1, 0, $year));

            $fechaini=$year.'-'.$month.'-01';
            $fechafin=$year.'-'.$month.'-'.$day;
        }elseif ($tipofecha==2) {

            $year = date('Y');

            $fechaini=$year.'-01-01';
            $fechafin=$year.'-12-31';
        }


            $reporte = array();

            foreach ($institucion as $key => $dato) { 

            $v1=0;
            $v2=0;
            $v3=0;
            $v4=0;

            $inicio = new DateTime($fechaini);
            $fin = new DateTime($fechafin);

            $now = new DateTime($fechnow);
            $init = new DateTime('2018-10-10');

            if($fin>$now){
                $fin==$now;
            }

            if($init>$inicio){
                $inicio==$init;
            }


            while ($inicio <= $fin) {

                $feriado=Feriado::where('activo','1')->where('borrado','0')->where('fecha',$fecha)->count();

                if(intval($feriado)==0){

                    $sql1="select i.nombre,ifnull(sum(a.canttotal),'0') as total, ifnull(sum(a.cantasist),'0') as cant, ifnull(sum(s.cantalumnos),'0') as alumnos
                    from seccions s
                    inner join grados g on g.id=s.grado_id
                    inner join datoscolegios d on d.id=g.datoscolegio_id
                    inner join institucions i on i.id=d.institucion_id
                    left join asistenciaalumnos a on s.id=a.seccion_id and a.fecha='".$inicio->format('Y-m-d')."'
                    where i.id='".$dato->id."' and g.borrado='0' and s.borrado='0'
                    order by i.id";

                     $consult1=DB::select($sql1);


                     foreach ($consult1 as $cantA) {

                        if(intval($cantA->total)==0){
                            $v3=$v3+intval($cantA->alumnos);
                        $v1=$v1+intval($cantA->cant);
                        }
                        else{
                            $v3=$v3+intval($cantA->total);
                        $v1=$v1+intval($cantA->cant);   
                        }

                        
                    

                }

                }

                $inicio->modify('+ 1 day');

            }

                $v2=$v3-$v1;

                if($v3>0){
                    $v4=(100*($v1))/$v3;
            }

            $porcen=number_format($v4, 2, '.', '');

            $newobj = new stdClass();
                $newobj->nombre = $dato->nombre;
                $newobj->idInstituto = $dato->id;
                $newobj->codigomod = $dato->codigomod;
                $newobj->nivel = $dato->nivel;
                $newobj->asistProgramadas = $v3;
                $newobj->asistRealizadas = $v1;
                $newobj->Faltas = $v2;
                $newobj->Porcentaje = $porcen;

                 $reporte[$key]=$newobj;
            }

            $result='1';
    $msj='Datos Consultados';


    return [

            'reporte'=>$reporte,
            'result'=>$result,
            'msj'=>$msj
        ];
    }


    public function buscar2(Request $request)
    {
        $idColegio=$request->idColegio;
        $idGrados=$request->idGrados;
        $idSeccions=$request->idSeccions;

        $tipofecha=$request->tipofecha;
        $fechaini=$request->fechaini;
        $fechafin=$request->fechafin;






            $fecha=date("Y-m-d");
            $fechnow=date("Y-m-d");
        $v1=0;
        $v2=0;
        $v3=0;
        $v4=0;

          $tipofecha=$request->tipofecha;
        $fechaini=$request->fechaini;
        $fechafin=$request->fechafin;

        if($tipofecha==0){
            $fechaini=date("Y-m-d");
            $fechafin=date("Y-m-d");
        }elseif ($tipofecha==1) {


            $month = date('m');
            $year = date('Y');
            $day = date("d", mktime(0,0,0, $month+1, 0, $year));

            $fechaini=$year.'-'.$month.'-01';
            $fechafin=$year.'-'.$month.'-'.$day;
        }elseif ($tipofecha==2) {

            $year = date('Y');

            $fechaini=$year.'-01-01';
            $fechafin=$year.'-12-31';
        }


            $reporte = array();




            $inicio = new DateTime($fechaini);
            $fin = new DateTime($fechafin);

            $now = new DateTime($fechnow);
            $init = new DateTime('2018-10-10');

            if($fin>$now){
                $fin==$now;
            }

            if($init>$inicio){
                $inicio==$init;
            }


            while ($inicio <= $fin) {

            $v1=0;
            $v2=0;
            $v3=0;
            $v4=0;

                $feriado=Feriado::where('activo','1')->where('borrado','0')->where('fecha',$fecha)->count();
                $fer='Si';
             $dia=0;

                if(intval($feriado)==0){
                    $fer='No';
                    $sql1="select i.nombre,ifnull(sum(a.canttotal),'0') as total, ifnull(sum(a.cantasist),'0') as cant, ifnull(sum(s.cantalumnos),'0') as alumnos
                    from seccions s
                    inner join grados g on g.id=s.grado_id
                    inner join datoscolegios d on d.id=g.datoscolegio_id
                    inner join institucions i on i.id=d.institucion_id
                    left join asistenciaalumnos a on s.id=a.seccion_id and a.fecha='".$inicio->format('Y-m-d')."'
                    where i.id='".$idColegio."' and g.borrado='0' and s.borrado='0';";

                     $consult1=DB::select($sql1);


                     foreach ($consult1 as $cantA) {

                        if(intval($cantA->total)==0){
                            $v3=$v3+intval($cantA->alumnos);
                        $v1=$v1+intval($cantA->cant);
                        }
                        else{
                            $v3=$v3+intval($cantA->total);
                        $v1=$v1+intval($cantA->cant);   
                        } 

                    }

                     $v2=$v3-$v1;

                if($v3>0){
                    $v4=(100*($v1))/$v3;
            }

            $porcen=number_format($v4, 2, '.', '');

            $day="";

            if(intval($dia)==1){
                $day="Lunes ";
            }elseif(intval($dia)==2){
                $day="Martes ";
            }elseif(intval($dia)==3){
                $day="Miercoles ";
            }elseif(intval($dia)==4){
                $day="Jueves ";
            }elseif(intval($dia)==5){
                $day="Viernes ";
            }elseif(intval($dia)==6){
                $day="Sábado ";
            }elseif(intval($dia)==7){
                $day="Domingo ";
            }
            
            $fechrep=$day.$inicio->format('d/m/Y');

            $newobj = new stdClass();
                $newobj->fecha = $fechrep;
                $newobj->feriado = $fer;
                $newobj->asistProgramadas = $v3;
                $newobj->asistRealizadas = $v1;
                $newobj->Faltas = $v2;
                $newobj->Porcentaje = $porcen;

                 $reporte[]=$newobj;



                }

                $inicio->modify('+ 1 day');

            }

               
         

            $result='1';
    $msj='Datos Consultados';


    return [

            'reporte'=>$reporte,
            'result'=>$result,
            'msj'=>$msj
        ];
    }


    public function buscar3(Request $request)
    {
        $idColegio=$request->idColegio;
        $idGrados=$request->idGrados;
        $idSeccions=$request->idSeccions;

        $tipofecha=$request->tipofecha;
        $fechaini=$request->fechaini;
        $fechafin=$request->fechafin;



        $institucion=DB::table('seccions')
                ->join('grados', 'seccions.grado_id', '=', 'grados.id')
                ->join('datoscolegios', 'datoscolegios.id', '=', 'grados.datoscolegio_id')
                ->join('institucions', 'institucions.id', '=', 'datoscolegios.institucion_id')

                ->where('seccions.activo','1')
                ->where('seccions.borrado','0')
                ->where('grados.activo','1')
                ->where('grados.borrado','0')
                ->where('institucions.id',$idColegio)
                ->orderBy('grados.id')
                ->orderBy('seccions.id')

                ->select('seccions.id as idSec','seccions.nombre as seccion','seccions.cantalumnos','grados.id as idgrados','grados.nombre as grado')->get();


            $fecha=date("Y-m-d");
                $fechnow=date("Y-m-d");
        $v1=0;
        $v2=0;
        $v3=0;
        $v4=0;

          $tipofecha=$request->tipofecha;
        $fechaini=$request->fechaini;
        $fechafin=$request->fechafin;

        if($tipofecha==0){
            $fechaini=date("Y-m-d");
            $fechafin=date("Y-m-d");
        }elseif ($tipofecha==1) {


            $month = date('m');
            $year = date('Y');
            $day = date("d", mktime(0,0,0, $month+1, 0, $year));

            $fechaini=$year.'-'.$month.'-01';
            $fechafin=$year.'-'.$month.'-'.$day;
        }elseif ($tipofecha==2) {

            $year = date('Y');

            $fechaini=$year.'-01-01';
            $fechafin=$year.'-12-31';
        }


            $reporte = array();

            foreach ($institucion as $key => $dato) { 

            $v1=0;
            $v2=0;
            $v3=0;
            $v4=0;

            $inicio = new DateTime($fechaini);
            $fin = new DateTime($fechafin);

            $now = new DateTime($fechnow);
            $init = new DateTime('2018-10-10');

            if($fin>$now){
                $fin==$now;
            }

            if($init>$inicio){
                $inicio==$init;
            }


            while ($inicio <= $fin) {

                $feriado=Feriado::where('activo','1')->where('borrado','0')->where('fecha',$fecha)->count();

                if(intval($feriado)==0){

                    $sql1="select ifnull((a.canttotal),'0') as total, ifnull((a.cantasist),'0') as cant, ifnull((s.cantalumnos),'0') as alumnos
                    from seccions s
                    left join asistenciaalumnos a on s.id=a.seccion_id and a.fecha='".$inicio->format('Y-m-d')."'
                    where s.id='".$dato->idSec."'  and s.borrado='0';";

                     $consult1=DB::select($sql1);


                     foreach ($consult1 as $cantA) {

                        if(intval($cantA->total)==0){
                            $v3=$v3+intval($cantA->alumnos);
                        $v1=$v1+intval($cantA->cant);
                        }
                        else{
                            $v3=$v3+intval($cantA->total);
                        $v1=$v1+intval($cantA->cant);   
                        }

                        
                    

                }

                }

                $inicio->modify('+ 1 day');

            }

                $v2=$v3-$v1;

                if($v3>0){
                    $v4=(100*($v1))/$v3;
            }

            $porcen=number_format($v4, 2, '.', '');

            $newobj = new stdClass();
                $newobj->grado = $dato->grado;
                $newobj->idSec = $dato->idSec;
                $newobj->seccion = $dato->seccion;
                $newobj->asistProgramadas = $v3;
                $newobj->asistRealizadas = $v1;
                $newobj->Faltas = $v2;
                $newobj->Porcentaje = $porcen;

                 $reporte[$key]=$newobj;
            }

            $result='1';
    $msj='Datos Consultados';


    return [

            'reporte'=>$reporte,
            'result'=>$result,
            'msj'=>$msj
        ];
    }

    public function create()
    {
        
    }

    public function getGrados($idCole)
    {
        //$grados=Grado::where('activo','1')->where('borrado','0')->where('datoscolegio_id',$idCole)->get();

        $grados=DB::select("select g.id, g.nombre, g.activo, g.borrado, g.datoscolegio_id , n.descripcion as nivel
            from grados g
inner join datoscolegios d on g.datoscolegio_id=d.id
inner join nivels n on n.id=d.nivel_id
where g.borrado='0' and d.institucion_id='".$idCole."';");

        return [

            'grados'=>$grados
        ];
    }

    public function getSeccions($idgrado)
    {
        $seccions=Seccion::where('activo','1')->where('borrado','0')->where('grado_id',$idgrado)->get();

        return [

            'seccions'=>$seccions
        ];
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
