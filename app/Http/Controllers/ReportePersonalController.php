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
use App\Feriado;

use Validator;
use Auth;
use DB;
use Storage;
use stdClass;
use DateTime;

set_time_limit(600);


class ReportePersonalController extends Controller
{
    public function index1()
    {
        if(accesoUser([1,2,3])){

            $iduser=Auth::user()->id;

            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);       
            $imagenPerfil="";
            $modulo="repAsistenciaPersonal";

              $fecha=date("d/m/Y");
            $mesActual=date("m");
        $yearActual=date("Y");



            return view('reportePersonal.index',compact('modulo','imagenPerfil','tipouser','mesActual','yearActual','fecha'));

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

        //$nivels=Nivel::where('activo','1')->where('borrado','0')->get();

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
                
                ->where('institucions.borrado','0')
                ->where('institucions.id',$idIE)

                ->select('institucions.id','institucions.nombre as nombre','institucions.direccion','institucions.telefono','institucions.correo','institucions.activo','institucions.tipo','datoscolegios.id as idcolegio','datoscolegios.zona','datoscolegios.codigomod','datoscolegios.clave8','datoscolegios.modalidad')->get();
            }
            else{
               // $institucion=Institucion::where('activo','1')->where('borrado','0')->where('tipo','2')->get()->paginate(35);;
                 $institucion=DB::table('institucions')
                 ->leftJoin('datoscolegios', 'datoscolegios.institucion_id', '=', 'institucions.id')
                ->where('institucions.borrado','0')

                ->select('institucions.id','institucions.nombre as nombre','institucions.direccion','institucions.telefono','institucions.correo','institucions.activo','institucions.tipo','datoscolegios.id as idcolegio','datoscolegios.zona','datoscolegios.codigomod','datoscolegios.clave8','datoscolegios.modalidad')->get();
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
        $idColegio=$request->idInsti;
        $idpersonal=$request->idPersonal;





         $institucion="";
                $iduser=Auth::user()->id;
        $idtipouser=Auth::user()->tipouser_id;
        $tipouser=Tipouser::find($idtipouser);

            if($idtipouser=="3" || intval($idColegio)>0){

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
                ->where('institucions.borrado','0')
                ->where('institucions.id',$idIE)

                ->select('institucions.id','institucions.nombre as nombre','institucions.direccion','institucions.telefono','institucions.correo','institucions.activo','institucions.tipo','datoscolegios.id as idcolegio','datoscolegios.zona','datoscolegios.codigomod','datoscolegios.clave8','datoscolegios.modalidad','nivels.descripcion as nivel')->get();
            }
            else{
               // $institucion=Institucion::where('activo','1')->where('borrado','0')->where('tipo','2')->get()->paginate(35);;
                 $institucion=DB::table('institucions')
                 ->leftJoin('datoscolegios', 'datoscolegios.institucion_id', '=', 'institucions.id')
                 ->leftJoin('nivels', 'datoscolegios.nivel_id', '=', 'nivels.id')
                ->where('institucions.borrado','0')

                ->select('institucions.id','institucions.nombre as nombre','institucions.direccion','institucions.telefono','institucions.correo','institucions.activo','institucions.tipo','datoscolegios.id as idcolegio','datoscolegios.zona','datoscolegios.codigomod','datoscolegios.clave8','datoscolegios.modalidad','nivels.descripcion as nivel')->get();
            }

            $numPersonal= array();
            $numTurnos= array();
            $dia=date("N");

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


                $sql1="select sum(case when a.asistencia = 1 then 1 else 0 end) as asistencia, sum(case when a.asistencia = 0 then 1 else 0 end) as falta
                 FROM asistenciapersonals a
                    inner join personals p on p.id=a.personal_id
                    inner join institucions i on i.id=p.institucion_id
                    where i.id='".$dato->id."'  and a.fecha='".$inicio->format('Y-m-d')."';";


                $consult1=DB::select($sql1);


                foreach ($consult1 as $cantA) {

                    $v1=$v1+intval($cantA->asistencia);
                    $v2=$v2+intval($cantA->falta);

                }

                if(($v2+$v1)==0){

                    $dia=date("N",$inicio->getTimestamp());

                    $cantpersonal1=DB::select("select ifnull(count(c.id),'0') as cant from personals p
inner join institucions i on i.id=p.institucion_id
inner join configdias c on p.id=c.personal_id
where i.id='".$dato->id."' and p.borrado='0'
and i.borrado='0'  and c.tipodia_id='".$dia."'
and ((c.fechaini<='".$inicio->format('Y-m-d')."' and c.fechafin>='".$inicio->format('Y-m-d')."' and c.borrado='1' and c.activo>0));");

                    $cantpersonal2=DB::select("select ifnull(count(c.id),'0') as cant from personals p
inner join institucions i on i.id=p.institucion_id
inner join configdias c on p.id=c.personal_id
where i.id='".$dato->id."' and p.borrado='0'
and i.borrado='0'  and c.tipodia_id='".$dia."'
and ((c.fechaini<='".$inicio->format('Y-m-d')."' and c.fechafin=c.fechaini and c.borrado='0' and c.activo>0));");

                    foreach ($cantpersonal1 as $cantF1) {

                    $v2=$v2+intval($cantF1->cant);

                }

                foreach ($cantpersonal2 as $cantF2) {

                    $v2=$v2+intval($cantF2->cant);

                }

                }

                

                }

                $inicio->modify('+ 1 day');

            }

            $v3=$v1+$v2;

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
        $idColegio=$request->idInsti;
        $idpersonal=$request->idPersonal;


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

            $personal=DB::select("select p.id,pe.nombres, pe.apellidos, pe.doc, p.cargo, concat(p.tipo,' ',p.subtipo) as tipo from personals p
                            inner join institucions i on i.id=p.institucion_id
                            inner join personas pe on pe.id=p.persona_id
                            where p.borrado='0' and i.id='".$idColegio."' and p.activo<2;");






            foreach ($personal as $key => $dato) {

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


                $sql1="select count(*) as cant FROM asistenciapersonals a
                    inner join personals p on p.id=a.personal_id
                    where p.id='".$dato->id."' and a.asistencia='1' and a.fecha='".$inicio->format('Y-m-d')."';";

                $sql2="select count(*) as cant FROM asistenciapersonals a
                    inner join personals p on p.id=a.personal_id
                    where p.id='".$dato->id."' and a.asistencia='0' and a.fecha='".$inicio->format('Y-m-d')."';";

                $consult1=DB::select($sql1);
                $consult2=DB::select($sql2);

                foreach ($consult1 as $cantA) {

                    $v1=$v1+intval($cantA->cant);

                }

                foreach ($consult2 as $cantF) {

                    $v2=$v2+intval($cantF->cant);

                }

                if(($v2+$v1)==0){

                    $dia=date("N",$inicio->getTimestamp());

                    $cantpersonal1=DB::select("select ifnull(count(c.id),'0') as cant from personals p
inner join configdias c on p.id=c.personal_id
where p.id='".$dato->id."' and p.borrado='0'
and c.tipodia_id='".$dia."'
and ((c.fechaini<='".$inicio->format('Y-m-d')."' and c.fechafin>='".$inicio->format('Y-m-d')."' and c.borrado='1' and c.activo>0));");

                    $cantpersonal2=DB::select("select ifnull(count(c.id),'0') as cant from personals p
inner join configdias c on p.id=c.personal_id
where p.id='".$dato->id."' and p.borrado='0'
and c.tipodia_id='".$dia."'
and ((c.fechaini<='".$inicio->format('Y-m-d')."' and c.fechafin=c.fechaini and c.borrado='0' and c.activo>0));");

                    foreach ($cantpersonal1 as $cantF1) {

                    $v2=$v2+intval($cantF1->cant);

                }

                foreach ($cantpersonal2 as $cantF2) {

                    $v2=$v2+intval($cantF2->cant);

                }

                }

                

                }

                $inicio->modify('+ 1 day');

            }

            $v3=$v1+$v2;

            if($v3>0){
                    $v4=(100*($v1))/$v3;
            }

            $porcen=number_format($v4, 2, '.', '');
            
            if($v3>0){

                    $newobj = new stdClass();
                $newobj->nombre = $dato->apellidos.', '.$dato->nombres;
                $newobj->dni = $dato->doc;
                $newobj->cargo = $dato->cargo;
                $newobj->asistProgramadas = $v3;
                $newobj->asistRealizadas = $v1;
                $newobj->Faltas = $v2;
                $newobj->Porcentaje = $porcen;
                $newobj->tipo = $dato->tipo;

                 $reporte[$key]=$newobj;
            }
             


            }

    $result='1';
    $msj='Datos Consultados';


    return [

            'reporte2'=>$reporte,
            'result'=>$result,
            'msj'=>$msj
        ];

}


public function buscar3(Request $request)
    {
        $idColegio=$request->idInsti;
        $idpersonal=$request->idPersonal;


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

            $v1=0;
            $v2=0;
            $v3=0;
            $v4=0;


             $feriado=Feriado::where('activo','1')->where('borrado','0')->where('fecha',$fecha)->count();
             $fer='Si';
             $dia=0;

            if(intval($feriado)==0){
                $fer='No';

                $sql1="select count(*) as cant FROM asistenciapersonals a
                    inner join personals p on p.id=a.personal_id
                    where p.id='".$idpersonal."' and a.asistencia='1' and a.fecha='".$inicio->format('Y-m-d')."';";

                $sql2="select count(*) as cant FROM asistenciapersonals a
                    inner join personals p on p.id=a.personal_id
                    where p.id='".$idpersonal."' and a.asistencia='0' and a.fecha='".$inicio->format('Y-m-d')."';";

                $consult1=DB::select($sql1);
                $consult2=DB::select($sql2);

                foreach ($consult1 as $cantA) {

                    $v1=$v1+intval($cantA->cant);

                }

                foreach ($consult2 as $cantF) {

                    $v2=$v2+intval($cantF->cant);

                }

                if(($v2+$v1)==0){

                    $dia=date("N",$inicio->getTimestamp());

                    $cantpersonal1=DB::select("select ifnull(count(c.id),'0') as cant from personals p
inner join configdias c on p.id=c.personal_id
where p.id='".$idpersonal."' and p.borrado='0'
and c.tipodia_id='".$dia."'
and ((c.fechaini<='".$inicio->format('Y-m-d')."' and c.fechafin>='".$inicio->format('Y-m-d')."' and c.borrado='1' and c.activo>0));");

                    $cantpersonal2=DB::select("select ifnull(count(c.id),'0') as cant from personals p
inner join configdias c on p.id=c.personal_id
where p.id='".$idpersonal."' and p.borrado='0'
and c.tipodia_id='".$dia."'
and ((c.fechaini<='".$inicio->format('Y-m-d')."' and c.fechafin=c.fechaini and c.borrado='0' and c.activo>0));");

                    foreach ($cantpersonal1 as $cantF1) {

                    $v2=$v2+intval($cantF1->cant);

                }

                foreach ($cantpersonal2 as $cantF2) {

                    $v2=$v2+intval($cantF2->cant);

                }

                }

                

                }

                $v3=$v1+$v2;

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


                 $reporte[]=$newobj;




                $inicio->modify('+ 1 day');

            }

            $t1=0;
            $t2=0;
            $t3=0;

            foreach ($reporte as $conteo) {
                $t1=$t1+intval($conteo->asistProgramadas);
                $t2=$t2+intval($conteo->asistRealizadas);
                $t3=$t3+intval($conteo->Faltas);
            }

            
             


            

    $result='1';
    $msj='Datos Consultados';


    return [

            'reporte3'=>$reporte,
            'result'=>$result,
            't1'=>$t1,
            't2'=>$t2,
            't3'=>$t3
        ];

}

    




    
    public function create()
    {
        
    }

    public function getPersonal($id)
    {
        $personals=DB::table('personals')
         ->join('personas', 'personals.persona_id', '=', 'personas.id')
        ->where('personals.activo','1')
        ->where('personals.borrado','0')
        ->where('personals.institucion_id',$id)
        ->orderBy('personals.institucion_id')
        ->orderBy('personas.apellidos')
        ->orderBy('personas.nombres')

        ->select('personals.id as idpersonal','personals.ley','personals.cargo','personas.doc','personas.nombres','personas.apellidos','personas.genero','personas.telefono','personas.direccion')->get();

        $nivels=DB::table('institucions')
            ->leftJoin('datoscolegios', 'datoscolegios.institucion_id', '=', 'institucions.id')
            ->leftJoin('nivels', 'datoscolegios.nivel_id', '=', 'nivels.id')
            ->where('institucions.id',$id)
             ->select('nivels.id','nivels.descripcion')->get();

             $nivel="";

             foreach ($nivels as $dato) {
                  $nivel=$dato->descripcion;
             }

        return [

            'personals'=>$personals,
            'nivel'=>$nivel
        ];
    }



    public function buscar4(Request $request)
    {
        $idColegio=$request->idInsti;
        $idpersonal=$request->idPersonal;


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

            $personal=DB::select("select p.id,pe.nombres, pe.apellidos, pe.doc, p.cargo, concat(p.tipo,' ',p.subtipo) as tipo , i.nombre as ie 
                            ,ifnull(concat('Código Modular ',d.codigomod),'') as codmod

                            from personals p
                            inner join institucions i on i.id=p.institucion_id
                            inner join personas pe on pe.id=p.persona_id
                            left join datoscolegios d on d.institucion_id=i.id
                            where p.borrado='0'  and p.activo<2;");






            foreach ($personal as $key => $dato) {

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


                $sql1="select count(*) as cant FROM asistenciapersonals a
                    inner join personals p on p.id=a.personal_id
                    where p.id='".$dato->id."' and a.asistencia='1' and a.fecha='".$inicio->format('Y-m-d')."';";

                $sql2="select count(*) as cant FROM asistenciapersonals a
                    inner join personals p on p.id=a.personal_id
                    where p.id='".$dato->id."' and a.asistencia='0' and a.fecha='".$inicio->format('Y-m-d')."';";

                $consult1=DB::select($sql1);
                $consult2=DB::select($sql2);

                foreach ($consult1 as $cantA) {

                    $v1=$v1+intval($cantA->cant);

                }

                foreach ($consult2 as $cantF) {

                    $v2=$v2+intval($cantF->cant);

                }

                if(($v2+$v1)==0){

                    $dia=date("N",$inicio->getTimestamp());

                    $cantpersonal1=DB::select("select ifnull(count(c.id),'0') as cant from personals p
inner join configdias c on p.id=c.personal_id
where p.id='".$dato->id."' and p.borrado='0'
and c.tipodia_id='".$dia."'
and ((c.fechaini<='".$inicio->format('Y-m-d')."' and c.fechafin>='".$inicio->format('Y-m-d')."' and c.borrado='1' and c.activo>0));");

                    $cantpersonal2=DB::select("select ifnull(count(c.id),'0') as cant from personals p
inner join configdias c on p.id=c.personal_id
where p.id='".$dato->id."' and p.borrado='0'
and c.tipodia_id='".$dia."'
and ((c.fechaini<='".$inicio->format('Y-m-d')."' and c.fechafin=c.fechaini and c.borrado='0' and c.activo>0));");

                    foreach ($cantpersonal1 as $cantF1) {

                    $v2=$v2+intval($cantF1->cant);

                }

                foreach ($cantpersonal2 as $cantF2) {

                    $v2=$v2+intval($cantF2->cant);

                }

                }

                

                }

                $inicio->modify('+ 1 day');

            }

            $v3=$v1+$v2;

            if($v3>0){
                    $v4=(100*($v1))/$v3;
            }

            $porcen=number_format($v4, 2, '.', '');
            
            if($v3>0){

                    $newobj = new stdClass();
                $newobj->nombre = $dato->apellidos.', '.$dato->nombres;
                $newobj->dni = $dato->doc;
                $newobj->cargo = $dato->cargo;
                $newobj->asistProgramadas = $v3;
                $newobj->asistRealizadas = $v1;
                $newobj->Faltas = $v2;
                $newobj->Porcentaje = $porcen;
                $newobj->tipo = $dato->tipo;
                $newobj->ie = $dato->ie.' '.$dato->codmod;

                 $reporte[$key]=$newobj;
            }
             


            }

    $result='1';
    $msj='Datos Consultados';


    return [

            'reporte4'=>$reporte,
            'result'=>$result,
            'msj'=>$msj
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
