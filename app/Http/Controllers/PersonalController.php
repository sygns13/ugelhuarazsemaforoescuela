<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\User;
use App\Tipouser;

use App\Institucion;
use App\Personal;
use App\Configdia;

use App\Tipodia;
use App\Turno;



use Validator;
use Auth;
use DB;
use Storage;
use stdClass;

class PersonalController extends Controller
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

        $persona=DB::table('personas')
        ->join('users', 'users.persona_id', '=', 'personas.id')
        ->join('tipousers','tipousers.id','=','users.tipouser_id')
        ->where('users.borrado','0')
        ->where('users.id',$iduser)
        ->select('personas.id as idper', 'personas.doc', 'personas.nombres as nombresPer', 'personas.apellidos as apePer', 'personas.genero', 'personas.telefono', 'personas.direccion', 'personas.tipodoc', 'users.id as idUsser', 'users.name as username', 'users.email','users.activo as activouser','tipousers.nombre as tipouser')->get();

            $imagenPerfil="";



        $modulo="personal";

        return view('personals.index',compact('modulo','tipouser','imagenPerfil'));

        }
    else
        {
            return view('adminlte::home');           
        }
    }



    public function index(Request $request)
    {
        $buscar=$request->busca;

        $iduser=Auth::user()->id;
        $idtipouser=Auth::user()->tipouser_id;
        $tipouser=Tipouser::find($idtipouser);

        $usuarios="";

        $personal="";
        $institucions="";

        $dato='0';

        $idPer='0';

        if(accesoUser([1,2])){
            $personals=DB::table('personals')
        ->join('personas', 'personals.persona_id', '=', 'personas.id')
        ->join('institucions', 'personals.institucion_id', '=', 'institucions.id')
        ->leftjoin('datoscolegios', 'datoscolegios.institucion_id', '=', 'institucions.id')
        ->where('institucions.borrado','0')
        ->where('personals.borrado','0')
        ->where('personals.activo','!=','2')
        ->where('personas.apellidos','like','%'.$buscar.'%')
        ->orderBy('institucions.id')
        ->orderBy('personas.apellidos')
        ->orderBy('personas.nombres')
        ->select('personals.id as idpersonal','personals.ley as ley','personals.cargo','personals.activo','personas.id as idper', 'personas.doc', 'personas.nombres as nombresPer', 'personas.apellidos as apePer', 'personas.genero', 'personas.telefono', 'personas.direccion', 'personas.tipodoc','institucions.id as idInsti','institucions.tipo as tipoinsti','institucions.nombre as nombreie','datoscolegios.codigomod')->paginate(30);

        $institucions=DB::table('institucions')
        ->leftJoin('datoscolegios',  function($join) use ($dato){
                    $join->on('institucions.id', '=', 'datoscolegios.institucion_id');
                    $join->on('datoscolegios.borrado', '=',DB::raw($dato));
                })
        ->where('institucions.borrado','0')
        ->select('institucions.id as idInsti','institucions.nombre as nombre','institucions.tipo','datoscolegios.codigomod')->get();

        }elseif(accesoUser([3])){

            $user=User::findOrFail($iduser);
                $persona=Persona::findOrFail($user->persona_id);

                $personal=Personal::where('persona_id',$persona->id)->get();
                $idIE="";
                foreach ($personal as $key => $datoper) {
                     $idIE=$datoper->institucion_id;
                }

                $personals=DB::table('personals')
        ->join('personas', 'personals.persona_id', '=', 'personas.id')
        ->join('institucions', 'personals.institucion_id', '=', 'institucions.id')
        ->leftjoin('datoscolegios', 'datoscolegios.institucion_id', '=', 'institucions.id')
        ->where('institucions.borrado','0')
        ->where('institucions.id',$idIE)
        ->where('personals.borrado','0')
        ->where('personals.activo','!=','2')
        ->where('personas.apellidos','like','%'.$buscar.'%')
        ->orderBy('institucions.id')
        ->orderBy('personas.apellidos')
        ->orderBy('personas.nombres')
        ->select('personals.id as idpersonal','personals.ley as ley','personals.cargo','personals.activo','personas.id as idper', 'personas.doc', 'personas.nombres as nombresPer', 'personas.apellidos as apePer', 'personas.genero', 'personas.telefono', 'personas.direccion', 'personas.tipodoc','institucions.id as idInsti','institucions.tipo as tipoinsti','institucions.nombre as nombreie','datoscolegios.codigomod')->paginate(30);

        $institucions=DB::table('institucions')
        ->leftJoin('datoscolegios',  function($join) use ($dato){
                    $join->on('institucions.id', '=', 'datoscolegios.institucion_id');
                    $join->on('datoscolegios.borrado', '=',DB::raw($dato));
                })
        ->where('institucions.borrado','0')
        ->where('institucions.id',$idIE)
        ->select('institucions.id as idInsti','institucions.nombre as nombre','institucions.tipo','datoscolegios.codigomod')->get();



        }

         

/*
        ->orWhere('personas.apellidos','like','%'.$buscar.'%')
        ->orWhere('institucions.nombre','like','%'.$buscar.'%')
*/
        
        //$idFin='0';


        $turnos= array();
        $turnos2= array();
        $turnos3= array();

        foreach ($personals as $key => $datox) {

        $turno=DB::table('configdias')
            ->join('personals', 'personals.id', '=', 'configdias.personal_id')
            ->join('turnos', 'turnos.id', '=', 'configdias.turno_id')
            ->join('tipodias', 'tipodias.id', '=', 'configdias.tipodia_id')

            ->where('personals.id',$datox->idpersonal)
            ->where('personals.borrado','0')
            ->where('configdias.borrado','0')

            ->where('configdias.activo','!=','2')
            ->where('configdias.activo','!=','3')

            ->orderBy('personals.id')
            ->orderBy('tipodias.id')

         ->select('configdias.id as idconfig','configdias.activo as activo','configdias.fechaini as fechaini','configdias.fechafin as fechafin','personals.id as idPer','turnos.id as idturnos','turnos.descripcion as turno','turnos.codigo as codturno','turnos.horaIni','turnos.horaFin','tipodias.id as iddia','tipodias.dia','tipodias.numdia')->get();

         $turnos[$key]=$turno;

 }

         foreach ($personals as $key => $datox) {

     /*   $turno=DB::table('configdias')
            ->join('personals', 'personals.id', '=', 'configdias.personal_id')
            ->join('turnos', 'turnos.id', '=', 'configdias.turno_id')
            ->join('tipodias', 'tipodias.id', '=', 'configdias.tipodia_id')

            ->where('personals.id',$datox->idpersonal)
            ->where('personals.borrado','0')
            ->where('configdias.borrado','0')
            ->where('configdias.activo','2')

            ->orderBy('personals.id')
            ->orderBy('tipodias.id')

         ->select('configdias.id as idconfig','configdias.activo as activo','configdias.fechaini as fechaini','configdias.fechafin as fechafin','personals.id as idPer','turnos.id as idturnos','turnos.descripcion as turno','turnos.codigo as codturno','turnos.horaIni','turnos.horaFin','tipodias.id as iddia','tipodias.dia','tipodias.numdia')->get();

*/

                  $turno=DB::select("select ifnull(`configdias`.`id`,0) as `idconfig`, ifnull(`configdias`.`activo`,0) as `activo`, `configdias`.`fechaini` as `fechaini`, `configdias`.`fechafin` as
`fechafin`, ifnull(`personals`.`id`,0) as `idPer`, ifnull(`turnos`.`id`,0) as `idturnos`, `turnos`.`descripcion` as `turno`, `turnos`.`codigo` as `codturno`,
`turnos`.`horaIni`, `turnos`.`horaFin`, `tipodias`.`id` as `iddia`, `tipodias`.`dia`, `tipodias`.`numdia`

from `tipodias`
left join `configdias` on `tipodias`.`id` = `configdias`.`tipodia_id` and `configdias`.`borrado`= 0 and `configdias`.`activo`= 2 and `configdias`.`personal_id`='".$datox->idpersonal."'
left join `personals` on `personals`.`id` = `configdias`.`personal_id` and `personals`.`id` ='".$datox->idpersonal."' and `personals`.`borrado` = 0
left join `turnos` on `turnos`.`id` = `configdias`.`turno_id`

  order by `tipodias`.`id` asc;");

        $b=false;
         foreach ($turno as $value) {
             $b=true;
         }

         if ($b==true) {

           $turnos2[$key]=$turno;

        }else{

             $arr= array();
             $newobj = new stdClass();
                $newobj->idPer = 0;
                $newobj->activo = 0;
                $newobj->idturnos = 0;
                $newobj->idconfig = 0;

                 $arr[0]=$newobj;
 

            $turnos2[$key]= $arr;
        }

         




        }

        foreach ($personals as $key => $datox) {

       /* $turno=DB::table('configdias')
            ->join('personals', 'personals.id', '=', 'configdias.personal_id')
            ->join('turnos', 'turnos.id', '=', 'configdias.turno_id')
            ->join('tipodias', 'tipodias.id', '=', 'configdias.tipodia_id')

            ->where('personals.id',$datox->idpersonal)
            ->where('personals.borrado','0')
            ->where('configdias.borrado','0')
            ->where('configdias.activo','3')

            ->orderBy('personals.id')
            ->orderBy('tipodias.id')

         ->select('configdias.id as idconfig','configdias.activo as activo','configdias.fechaini as fechaini','configdias.fechafin as fechafin','personals.id as idPer','turnos.id as idturnos','turnos.descripcion as turno','turnos.codigo as codturno','turnos.horaIni','turnos.horaFin','tipodias.id as iddia','tipodias.dia','tipodias.numdia')->get();*/

         $turno=DB::select("select ifnull(`configdias`.`id`,0) as `idconfig`, ifnull(`configdias`.`activo`,0) as `activo`, `configdias`.`fechaini` as `fechaini`, `configdias`.`fechafin` as
`fechafin`, ifnull(`personals`.`id`,0) as `idPer`, ifnull(`turnos`.`id`,0) as `idturnos`, `turnos`.`descripcion` as `turno`, `turnos`.`codigo` as `codturno`,
`turnos`.`horaIni`, `turnos`.`horaFin`, `tipodias`.`id` as `iddia`, `tipodias`.`dia`, `tipodias`.`numdia`

from `tipodias`
left join `configdias` on `tipodias`.`id` = `configdias`.`tipodia_id` and `configdias`.`borrado`= 0 and `configdias`.`activo`= 3 and `configdias`.`personal_id`='".$datox->idpersonal."'
left join `personals` on `personals`.`id` = `configdias`.`personal_id` and `personals`.`id` ='".$datox->idpersonal."' and `personals`.`borrado` = 0
left join `turnos` on `turnos`.`id` = `configdias`.`turno_id`

  order by `tipodias`.`id` asc;");

      
         $b=false;
         foreach ($turno as $value) {
             $b=true;
         }

         if ($b==true) {

           $turnos3[$key]=$turno;

        }

        else{
            $arr= array();
             $newobj = new stdClass();
                $newobj->idPer = 0;
                $newobj->activo = 0;
                $newobj->idturnos = 0;
                $newobj->idconfig = 0;


                 $arr[0]=$newobj;


            $turnos3[$key]= $arr;
        }




        }





        
        

        $turns=Turno::where('tipo','1')->where('activo','1')->where('borrado','0')->get();


        return [
            'pagination'=>[
                'total'=> $personals->total(),
                'current_page'=> $personals->currentPage(),
                'per_page'=> $personals->perPage(),
                'last_page'=> $personals->lastPage(),
                'from'=> $personals->firstItem(),
                'to'=> $personals->lastItem(),
            ],
            'personals'=>$personals,
            'institucions'=>$institucions,
            'turnos'=>$turnos,
            'turnos2'=>$turnos2,
            'turnos3'=>$turnos3,
            'turns'=>$turns
        ];
    }



    public function verpersona($dni)
    {
       $persona=Persona::where('doc',$dni)->get();


       /*   $persona=DB::table('personas')
        ->join('personals', 'personals.persona_id', '=', 'personas.id')
        ->join('institucions', 'personals.institucion_id', '=', 'institucions.id')
        ->where('personals.borrado','0')
        ->where('personas.borrado','0')
        ->where('personas.doc',$dni)
        ->select('personas.id','personas.doc','personas.tipodoc','personas.nombres','personas.apellidos','personas.genero','personas.telefono','personas.direccion','personas.activo','personas.borrado','personals.id as idPersonal','personals.institucion_id','institucions.tipo as tipoinsti')->get();*/

       $id="0";
       $idPer="0";

       foreach ($persona as $key => $dato) {
          $id=$dato->id;
       }

       $personal=Personal::where('persona_id',$id)->where('borrado','0')->get();

       foreach ($personal as $key => $dato) {
          $idPer=$dato->id;
       }


       return response()->json(["persona"=>$persona, "id"=>$id, "personal"=>$personal , "idPer"=>$idPer]);

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
         $result='1';
        $msj='';
        $selector='';

        $idPersona=$request->idPersona;
        $idPersonal=$request->idPersonal;

        $newDNI=$request->newDNI;
        $newNombres=$request->newNombres;
        $newApellidos=$request->newApellidos;
        $newGenero=$request->newGenero;
        $newTelefono=$request->newTelefono;
        $newDireccion=$request->newDireccion;
        
        $newTipoDocu="1";

        $cbuIE=$request->cbuIE;
        $cbuLey=$request->cbuLey;
        $cbuCargos=$request->cbuCargos;

        $newEstado=$request->newEstado;


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



        $input1  = array('newDNI' => $newDNI);
        $reglas1 = array('newDNI' => 'required');

        $input2  = array('nombres' => $newNombres);
        $reglas2 = array('nombres' => 'required');

        $input3  = array('apellidos' => $newApellidos);
        $reglas3 = array('apellidos' => 'required');



        //$input6  = array('carrera' => $newCarrerasunasam);
       // $reglas6 = array('carrera' => 'required');

        // Segunda Carrera OP chekiar $newcarrera_id2

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);
         $validator3 = Validator::make($input3, $reglas3);

         //$validator6 = Validator::make($input6, $reglas6);

         if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el DNI del Personal';
            $selector='txtDNI';
        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Debe ingresar el nombre del Personal';
            $selector='txtnombres';
        }elseif ($validator3->fails()) {
            $result='0';
            $msj='Debe ingresar los Apellidos del Personal';
            $selector='txtapellidos';
        }
        else{


                $input7  = array('cbuIE' => $cbuIE);
                $reglas7 = array('cbuIE' => 'required');

                $input9  = array('cbuLey' => $cbuLey);
                $reglas9 = array('cbuLey' => 'required');

                $input11  = array('cbuCargos' => $cbuCargos);
                $reglas11 = array('cbuCargos' => 'required');


                $validator7 = Validator::make($input7, $reglas7);

                $validator9 = Validator::make($input9, $reglas9);

                $validator11 = Validator::make($input11, $reglas11);

                    if(Strval($cbuIE)=="null"){
                        $result='2';
                        $msj='Debe seleccionar una institución a la que pertenezca el personal';
                        $selector='cbuIE';
                    }
                    elseif (Strval($cbuLey)=="null")
                    {
                        $result='2';
                        $msj='Debe seleccionar el Régimen Laboral del trabajador';
                        $selector='cbuLey';
                    }elseif (Strval($cbuCargos)=="null") {
                        $result='2';
                        $msj='Debe seleccionar el Cargo del Trabajador';
                        $selector='cbuCargos';
                    }
                    else
                    {
                        //$idPersona
                         if($idPersona=="0"){

                            $newPersona = new Persona();

                                $newPersona->doc=$newDNI;
                                $newPersona->tipodoc=$newTipoDocu;
                                $newPersona->nombres=$newNombres;
                                $newPersona->apellidos=$newApellidos;
                                $newPersona->genero=$newGenero;
                                $newPersona->telefono=$newTelefono;
                                $newPersona->direccion=$newDireccion;
                   
                                $newPersona->activo='1';
                                $newPersona->borrado='0';
                                

                            $newPersona->save();

                            $newPersonal = new Personal();

                                $newPersonal->ley=$cbuLey;
                                $newPersonal->tiporegistro='';
  
                                $newPersonal->estado='';
                                $newPersonal->jornada='';
                                $newPersonal->categoria='';
                                $newPersonal->motivovacante='';
                   
                                $newPersonal->situacionlab='';
                                $newPersonal->cargo=$cbuCargos;
                                $newPersonal->tipo='';
                                $newPersonal->subtipo='';
                                $newPersonal->codplaza='';
                                $newPersonal->activo=$newEstado;
                                $newPersonal->borrado='0';
                                $newPersonal->persona_id=$newPersona->id;
                                $newPersonal->institucion_id=$cbuIE;


                            $newPersonal->save();

                            $fecha=date("Y/m/d");
                             //Lunes
            $newConfig1 = new Configdia();
                $newConfig1->tipo='1'; 
                $newConfig1->tipodia_id='1';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig1->personal_id=$newPersonal->id;
                $newConfig1->activo=$check1;
                $newConfig1->borrado='0';
                $newConfig1->fechaini=$fecha;
                $newConfig1->fechafin=$fecha;
                $newConfig1->turno_id=$idturno;
            $newConfig1->save();

            //Martes
            $newConfig2 = new Configdia();
                $newConfig2->tipo='1'; 
                $newConfig2->tipodia_id='2';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig2->personal_id=$newPersonal->id;
                $newConfig2->activo=$check2;
                $newConfig2->borrado='0';
                $newConfig2->fechaini=$fecha;
                $newConfig2->fechafin=$fecha;
                $newConfig2->turno_id=$idturno;
            $newConfig2->save();

            //Miercoles
            $newConfig3 = new Configdia();
                $newConfig3->tipo='1'; 
                $newConfig3->tipodia_id='3';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig3->personal_id=$newPersonal->id;
                $newConfig3->activo=$check3;
                $newConfig3->borrado='0';
                $newConfig3->fechaini=$fecha;
                $newConfig3->fechafin=$fecha;
                $newConfig3->turno_id=$idturno;
            $newConfig3->save();

            //Jueves
            $newConfig4 = new Configdia();
                $newConfig4->tipo='1'; 
                $newConfig4->tipodia_id='4';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig4->personal_id=$newPersonal->id;
                $newConfig4->activo=$check4;
                $newConfig4->borrado='0';
                $newConfig4->fechaini=$fecha;
                $newConfig4->fechafin=$fecha;
                $newConfig4->turno_id=$idturno;
            $newConfig4->save();

            //Viernes
            $newConfig5 = new Configdia();
                $newConfig5->tipo='1'; 
                $newConfig5->tipodia_id='5';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig5->personal_id=$newPersonal->id;
                $newConfig5->activo=$check5;
                $newConfig5->borrado='0';
                $newConfig5->fechaini=$fecha;
                $newConfig5->fechafin=$fecha;
                $newConfig5->turno_id=$idturno;
            $newConfig5->save();

            //Sabado
            $newConfig6 = new Configdia();
                $newConfig6->tipo='1'; 
                $newConfig6->tipodia_id='6';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig6->personal_id=$newPersonal->id;
                $newConfig6->activo=$check6;
                $newConfig6->borrado='0';
                $newConfig6->fechaini=$fecha;
                $newConfig6->fechafin=$fecha;
                $newConfig6->turno_id=$idturno;
            $newConfig6->save();

            //Domingo
            $newConfig7 = new Configdia();
                $newConfig7->tipo='1'; 
                $newConfig7->tipodia_id='7';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig7->personal_id=$newPersonal->id;
                $newConfig7->activo=$check7;
                $newConfig7->borrado='0';
                $newConfig7->fechaini=$fecha;
                $newConfig7->fechafin=$fecha;
                $newConfig7->turno_id=$idturno;
            $newConfig7->save();


                            $msj='Nuevo Personal registrado con éxito';

                        }
                        else{
                            //editar Persona



                            $editPersona = Persona::findOrFail($idPersona);


       
                                $editPersona->doc=$newDNI;
                                $editPersona->tipodoc=$newTipoDocu;
                                $editPersona->nombres=$newNombres;
                                $editPersona->apellidos=$newApellidos;
                                $editPersona->genero=$newGenero;
                                $editPersona->telefono=$newTelefono;
                                $editPersona->direccion=$newDireccion;

                            $editPersona->save();
                       



                            $newPersonal = new Personal();

                                $newPersonal->ley=$cbuLey;
                                $newPersonal->tiporegistro='';
  
                                $newPersonal->estado='';
                                $newPersonal->jornada='';
                                $newPersonal->categoria='';
                                $newPersonal->motivovacante='';
                   
                                $newPersonal->situacionlab='';
                                $newPersonal->cargo=$cbuCargos;
                                $newPersonal->tipo='';
                                $newPersonal->subtipo='';
                                $newPersonal->codplaza='';
                                $newPersonal->activo=$newEstado;
                                $newPersonal->borrado='0';
                                $newPersonal->persona_id=$editPersona->id;
                                $newPersonal->institucion_id=$cbuIE;


                            $newPersonal->save();


                             $fecha=date("Y/m/d");
                             //Lunes
            $newConfig1 = new Configdia();
                $newConfig1->tipo='1'; 
                $newConfig1->tipodia_id='1';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig1->personal_id=$newPersonal->id;
                $newConfig1->activo=$check1;
                $newConfig1->borrado='0';
                $newConfig1->fechaini=$fecha;
                $newConfig1->fechafin=$fecha;
                $newConfig1->turno_id=$idturno;
            $newConfig1->save();

            //Martes
            $newConfig2 = new Configdia();
                $newConfig2->tipo='1'; 
                $newConfig2->tipodia_id='2';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig2->personal_id=$newPersonal->id;
                $newConfig2->activo=$check2;
                $newConfig2->borrado='0';
                $newConfig2->fechaini=$fecha;
                $newConfig2->fechafin=$fecha;
                $newConfig2->turno_id=$idturno;
            $newConfig2->save();

            //Miercoles
            $newConfig3 = new Configdia();
                $newConfig3->tipo='1'; 
                $newConfig3->tipodia_id='3';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig3->personal_id=$newPersonal->id;
                $newConfig3->activo=$check3;
                $newConfig3->borrado='0';
                $newConfig3->fechaini=$fecha;
                $newConfig3->fechafin=$fecha;
                $newConfig3->turno_id=$idturno;
            $newConfig3->save();

            //Jueves
            $newConfig4 = new Configdia();
                $newConfig4->tipo='1'; 
                $newConfig4->tipodia_id='4';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig4->personal_id=$newPersonal->id;
                $newConfig4->activo=$check4;
                $newConfig4->borrado='0';
                $newConfig4->fechaini=$fecha;
                $newConfig4->fechafin=$fecha;
                $newConfig4->turno_id=$idturno;
            $newConfig4->save();

            //Viernes
            $newConfig5 = new Configdia();
                $newConfig5->tipo='1'; 
                $newConfig5->tipodia_id='5';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig5->personal_id=$newPersonal->id;
                $newConfig5->activo=$check5;
                $newConfig5->borrado='0';
                $newConfig5->fechaini=$fecha;
                $newConfig5->fechafin=$fecha;
                $newConfig5->turno_id=$idturno;
            $newConfig5->save();

            //Sabado
            $newConfig6 = new Configdia();
                $newConfig6->tipo='1'; 
                $newConfig6->tipodia_id='6';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig6->personal_id=$newPersonal->id;
                $newConfig6->activo=$check6;
                $newConfig6->borrado='0';
                $newConfig6->fechaini=$fecha;
                $newConfig6->fechafin=$fecha;
                $newConfig6->turno_id=$idturno;
            $newConfig6->save();

            //Domingo
            $newConfig7 = new Configdia();
                $newConfig7->tipo='1'; 
                $newConfig7->tipodia_id='7';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig7->personal_id=$newPersonal->id;
                $newConfig7->activo=$check7;
                $newConfig7->borrado='0';
                $newConfig7->fechaini=$fecha;
                $newConfig7->fechafin=$fecha;
                $newConfig7->turno_id=$idturno;
            $newConfig7->save();




                            $msj='Nuevo Personal registrado con éxito';
                        }
                       
                    

            }
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
       $result='1';
        $msj='';
        $selector='';

        $idPersona=$request->idPersona;
        $idPersonal=$request->idPersonal;

        $editDNI=$request->editDNI;
        $editNombres=$request->editNombres;
        $editApellidos=$request->editApellidos;
        $editGenero=$request->editGenero;
        $editTelefono=$request->editTelefono;
        $editDireccion=$request->editDireccion;

        $editTipoDocu=$request->editTipoDocu;


        $ley=$request->ley;
        $cargo=$request->cargo;
        $instis=$request->instis;

        $idtipo=$request->idtipo;
        $institucion_id=$request->institucion_id;
        $activo=$request->activo;

        $input1  = array('dni' => $editDNI);
        $reglas1 = array('dni' => 'required');

        $input0  = array('dni' => $editDNI);
        $reglas0 = array('dni' => 'unique:personas,dni,'.$id.',id,borrado,0');

        $input2  = array('nombres' => $editNombres);
        $reglas2 = array('nombres' => 'required');

        $input3  = array('apellidos' => $editApellidos);
        $reglas3 = array('apellidos' => 'required');



         $validator1 = Validator::make($input1, $reglas1);
         $validator0 = Validator::make($input0, $reglas0);
         $validator2 = Validator::make($input2, $reglas2);
         $validator3 = Validator::make($input3, $reglas3);
         //$validator6 = Validator::make($input6, $reglas6);

         if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el DNI del usuario';
            $selector='txtDNIE';
        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Debe ingresar el nombre del usuario';
            $selector='txtnombresE';
        }elseif ($validator3->fails()) {
            $result='0';
            $msj='Debe ingresar los Apellidos del usuario';
            $selector='txtapellidosE';
        }
        else{

                 if(Strval($institucion_id)=="null"){
                        $result='2';
                        $msj='Debe seleccionar una institución a la que pertenezca el personal';
                        $selector='cbuLeyE';
                    }
                    elseif (Strval($ley)=="null")
                    {
                        $result='2';
                        $msj='Debe seleccionar el Régimen Laboral del trabajador';
                        $selector='cbuLeyE';
                    }elseif (Strval($cargo)=="null") {
                        $result='2';
                        $msj='Debe seleccionar el Cargo del Trabajador';
                        $selector='cbuCargosE';
                    }
                    else
                    {

                         $editPersona = Persona::findOrFail($idPersona);

                   
                                $editPersona->nombres=$editNombres;
                                $editPersona->apellidos=$editApellidos;
                                $editPersona->genero=$editGenero;
                                $editPersona->telefono=$editTelefono;
                                $editPersona->direccion=$editDireccion;

                            $editPersona->save();
                       

                            $editPersonal = Personal::findOrFail($idPersonal);

                                $editPersonal->ley=$ley;
                                $editPersonal->cargo=$cargo;
                                $editPersonal->activo=$activo;          
                                $editPersonal->institucion_id=$institucion_id;

                                $editPersonal->activo=$activo;


                            $editPersonal->save();


                            $msj='Personal modificado con éxito';

                      }

          

        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function EditTurnos(Request $request)
    {
        $idPersonal=$request->id;

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



        $id2Config1=$request->id2Config1;
        $id2Config2=$request->id2Config2;
        $id2Config3=$request->id2Config3;
        $id2Config4=$request->id2Config4;
        $id2Config5=$request->id2Config5;
        $id2Config6=$request->id2Config6;
        $id2Config7=$request->id2Config7;



        $turno2OpE1=$request->turno2OpE1;
        $turno2OpE2=$request->turno2OpE2;
        $turno2OpE3=$request->turno2OpE3;
        $turno2OpE4=$request->turno2OpE4;
        $turno2OpE5=$request->turno2OpE5;
        $turno2OpE6=$request->turno2OpE6;
        $turno2OpE7=$request->turno2OpE7;


        $id3Config1=$request->id3Config1;
        $id3Config2=$request->id3Config2;
        $id3Config3=$request->id3Config3;
        $id3Config4=$request->id3Config4;
        $id3Config5=$request->id3Config5;
        $id3Config6=$request->id3Config6;
        $id3Config7=$request->id3Config7;



        $turno3OpE1=$request->turno3OpE1;
        $turno3OpE2=$request->turno3OpE2;
        $turno3OpE3=$request->turno3OpE3;
        $turno3OpE4=$request->turno3OpE4;
        $turno3OpE5=$request->turno3OpE5;
        $turno3OpE6=$request->turno3OpE6;
        $turno3OpE7=$request->turno3OpE7;

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


        /***********************Primer Turno ***********************/

        $editConfig1 = Configdia::find($idConfig1);
        if ($editConfig1 != null){
        $editConfig1->borrado='1';
        $editConfig1->fechafin=$fecha;
        $editConfig1->save();
        }

        $editConfig2 = Configdia::find($idConfig2);
        if ($editConfig2 != null){
        $editConfig2->borrado='1';
        $editConfig2->fechafin=$fecha;
        $editConfig2->save();
        }

        $editConfig3 = Configdia::find($idConfig3);
        if ($editConfig3 != null){
        $editConfig3->borrado='1';
        $editConfig3->fechafin=$fecha;
        $editConfig3->save();
        }

        $editConfig4 = Configdia::find($idConfig4);
        if ($editConfig4 != null){
        $editConfig4->borrado='1';
        $editConfig4->fechafin=$fecha;
        $editConfig4->save();
         }

        $editConfig5 = Configdia::find($idConfig5);
        if ($editConfig5 != null){
        $editConfig5->borrado='1';
        $editConfig5->fechafin=$fecha;
        $editConfig5->save();
        }

        $editConfig6 = Configdia::find($idConfig6);
        if ($editConfig6 != null){
        $editConfig6->borrado='1';
        $editConfig6->fechafin=$fecha;
        $editConfig6->save();
        }

        $editConfig7 = Configdia::find($idConfig7);
        if ($editConfig7 != null){
        $editConfig7->borrado='1';
        $editConfig7->fechafin=$fecha;
        $editConfig7->save();
        }



        /***********************Segundo Turno ***********************/



        $edit2Config1 = Configdia::find($id2Config1);

        if ($edit2Config1 != null){
        $edit2Config1->borrado='1';
        $edit2Config1->fechafin=$fecha;
        $edit2Config1->save();

        }

        
        $edit2Config2 = Configdia::find($id2Config2);

        if ($edit2Config2 != null){
        $edit2Config2->borrado='1';
        $edit2Config2->fechafin=$fecha;
        $edit2Config2->save();

        }

        $edit2Config3 = Configdia::find($id2Config3);

        if ($edit2Config3 != null){
        $edit2Config3->borrado='1';
        $edit2Config3->fechafin=$fecha;
        $edit2Config3->save();

        }


        $edit2Config4 = Configdia::find($id2Config4);

        if ($edit2Config4 != null){
        $edit2Config4->borrado='1';
        $edit2Config4->fechafin=$fecha;
        $edit2Config4->save();

        }

        $edit2Config5 = Configdia::find($id2Config5);

         if ($edit2Config5 != null){
        $edit2Config5->borrado='1';
        $edit2Config5->fechafin=$fecha;
        $edit2Config5->save();

         }

        $edit2Config6 = Configdia::find($id2Config6);

        if ($edit2Config6 != null){

        $edit2Config6->borrado='1';
        $edit2Config6->fechafin=$fecha;
        $edit2Config6->save();

        }

        $edit2Config7 = Configdia::find($id2Config7);

        if ($edit2Config7 != null){


        $edit2Config7->borrado='1';
        $edit2Config7->fechafin=$fecha;
        $edit2Config7->save();

        }

        /***********************Tercer Turno ***********************/




        $edit3Config1 = Configdia::find($id3Config1);

        if ($edit3Config1 != null){
        $edit3Config1->borrado='1';
        $edit3Config1->fechafin=$fecha;
        $edit3Config1->save();

        }

        
        $edit3Config2 = Configdia::find($id3Config2);

        if ($edit3Config2 != null){
        $edit3Config2->borrado='1';
        $edit3Config2->fechafin=$fecha;
        $edit3Config2->save();

        }

        $edit3Config3 = Configdia::find($id3Config3);

        if ($edit3Config3 != null){
        $edit3Config3->borrado='1';
        $edit3Config3->fechafin=$fecha;
        $edit3Config3->save();

        }


        $edit3Config4 = Configdia::find($id3Config4);

        if ($edit3Config4 != null){
        $edit3Config4->borrado='1';
        $edit3Config4->fechafin=$fecha;
        $edit3Config4->save();

        }

        $edit3Config5 = Configdia::find($id3Config5);

         if ($edit3Config5 != null){
        $edit3Config5->borrado='1';
        $edit3Config5->fechafin=$fecha;
        $edit3Config5->save();

         }

        $edit3Config6 = Configdia::find($id3Config6);

        if ($edit3Config6 != null){

        $edit3Config6->borrado='1';
        $edit3Config6->fechafin=$fecha;
        $edit3Config6->save();

        }

        $edit3Config7 = Configdia::find($id3Config7);

        if ($edit3Config7 != null){


        $edit3Config7->borrado='1';
        $edit3Config7->fechafin=$fecha;
        $edit3Config7->save();

        }


/******************************* Turnos Primeros*********************/

         //Lunes
            $newConfig1 = new Configdia();
                $newConfig1->tipo='1'; 
                $newConfig1->tipodia_id='1';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig1->personal_id=$idPersonal;
                $newConfig1->activo=$check1E;
                $newConfig1->borrado='0';
                $newConfig1->fechaini=$fecha;
                $newConfig1->fechafin=$fecha;
                $newConfig1->turno_id=$turnoOpE1;
            $newConfig1->save();

            //Martes
            $newConfig2 = new Configdia();
                $newConfig2->tipo='1'; 
                $newConfig2->tipodia_id='2';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig2->personal_id=$idPersonal;
                $newConfig2->activo=$check2E;
                $newConfig2->borrado='0';
                $newConfig2->fechaini=$fecha;
                $newConfig2->fechafin=$fecha;
                $newConfig2->turno_id=$turnoOpE2;
            $newConfig2->save();

            //Miercoles
            $newConfig3 = new Configdia();
                $newConfig3->tipo='1'; 
                $newConfig3->tipodia_id='3';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig3->personal_id=$idPersonal;
                $newConfig3->activo=$check3E;
                $newConfig3->borrado='0';
                $newConfig3->fechaini=$fecha;
                $newConfig3->fechafin=$fecha;
                $newConfig3->turno_id=$turnoOpE3;
            $newConfig3->save();

            //Jueves
            $newConfig4 = new Configdia();
                $newConfig4->tipo='1'; 
                $newConfig4->tipodia_id='4';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig4->personal_id=$idPersonal;
                $newConfig4->activo=$check4E;
                $newConfig4->borrado='0';
                $newConfig4->fechaini=$fecha;
                $newConfig4->fechafin=$fecha;
                $newConfig4->turno_id=$turnoOpE4;
            $newConfig4->save();

            //Viernes
            $newConfig5 = new Configdia();
                $newConfig5->tipo='1'; 
                $newConfig5->tipodia_id='5';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig5->personal_id=$idPersonal;
                $newConfig5->activo=$check5E;
                $newConfig5->borrado='0';
                $newConfig5->fechaini=$fecha;
                $newConfig5->fechafin=$fecha;
                $newConfig5->turno_id=$turnoOpE5;
            $newConfig5->save();

            //Sabado
            $newConfig6 = new Configdia();
                $newConfig6->tipo='1'; 
                $newConfig6->tipodia_id='6';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig6->personal_id=$idPersonal;
                $newConfig6->activo=$check6E;
                $newConfig6->borrado='0';
                $newConfig6->fechaini=$fecha;
                $newConfig6->fechafin=$fecha;
                $newConfig6->turno_id=$turnoOpE6;
            $newConfig6->save();

            //Domingo
            $newConfig7 = new Configdia();
                $newConfig7->tipo='1'; 
                $newConfig7->tipodia_id='7';//Tipo Dia del 1 al 7, esto no es editable 
                $newConfig7->personal_id=$idPersonal;
                $newConfig7->activo=$check7E;
                $newConfig7->borrado='0';
                $newConfig7->fechaini=$fecha;
                $newConfig7->fechafin=$fecha;
                $newConfig7->turno_id=$turnoOpE7;
            $newConfig7->save();


/******************************* Turnos Segundos*********************/



        //Lunes

        if(intval($turno2OpE1)!=0 && intval($turno2OpE1)!=intval($turnoOpE1) &&  $check1E==1)
        {
            $new2Config1 = new Configdia();
                $new2Config1->tipo='1'; 
                $new2Config1->tipodia_id='1';//Tipo Dia del 1 al 7, esto no es editable 
                $new2Config1->personal_id=$idPersonal;
                $new2Config1->activo='2';
                $new2Config1->borrado='0';
                $new2Config1->fechaini=$fecha;
                $new2Config1->fechafin=$fecha;
                $new2Config1->turno_id=$turno2OpE1;
            $new2Config1->save();
        }
            

            //Martes

        if(intval($turno2OpE2)!=0 && intval($turno2OpE2)!=intval($turnoOpE2) &&  $check2E==1)
        {
            $new2Config2 = new Configdia();
                $new2Config2->tipo='1'; 
                $new2Config2->tipodia_id='2';//Tipo Dia del 1 al 7, esto no es editable 
                $new2Config2->personal_id=$idPersonal;
                $new2Config2->activo='2';
                $new2Config2->borrado='0';
                $new2Config2->fechaini=$fecha;
                $new2Config2->fechafin=$fecha;
                $new2Config2->turno_id=$turno2OpE2;
            $new2Config2->save();

        }

            //Miercoles

        if(intval($turno2OpE3)!=0 && intval($turno2OpE3)!=intval($turnoOpE3) &&  $check3E==1)
        {
            $new2Config3 = new Configdia();
                $new2Config3->tipo='1'; 
                $new2Config3->tipodia_id='3';//Tipo Dia del 1 al 7, esto no es editable 
                $new2Config3->personal_id=$idPersonal;
                $new2Config3->activo='2';
                $new2Config3->borrado='0';
                $new2Config3->fechaini=$fecha;
                $new2Config3->fechafin=$fecha;
                $new2Config3->turno_id=$turno2OpE3;
            $new2Config3->save();

        }

            //Jueves

        if(intval($turno2OpE4)!=0 && intval($turno2OpE4)!=intval($turnoOpE4) &&  $check4E==1)
        {
            $new2Config4 = new Configdia();
                $new2Config4->tipo='1'; 
                $new2Config4->tipodia_id='4';//Tipo Dia del 1 al 7, esto no es editable 
                $new2Config4->personal_id=$idPersonal;
                $new2Config4->activo='2';
                $new2Config4->borrado='0';
                $new2Config4->fechaini=$fecha;
                $new2Config4->fechafin=$fecha;
                $new2Config4->turno_id=$turno2OpE4;
            $new2Config4->save();

        }

            //Viernes

        if(intval($turno2OpE5)!=0 && intval($turno2OpE5)!=intval($turnoOpE5) &&  $check5E==1)
        {
            $new2Config5 = new Configdia();
                $new2Config5->tipo='1'; 
                $new2Config5->tipodia_id='5';//Tipo Dia del 1 al 7, esto no es editable 
                $new2Config5->personal_id=$idPersonal;
                $new2Config5->activo='2';
                $new2Config5->borrado='0';
                $new2Config5->fechaini=$fecha;
                $new2Config5->fechafin=$fecha;
                $new2Config5->turno_id=$turno2OpE5;
            $new2Config5->save();

        }

        //Sabado

        if(intval($turno2OpE6)!=0 && intval($turno2OpE6)!=intval($turnoOpE6) &&  $check6E==1)
        {
            
            $new2Config6 = new Configdia();
                $new2Config6->tipo='1'; 
                $new2Config6->tipodia_id='6';//Tipo Dia del 1 al 7, esto no es editable 
                $new2Config6->personal_id=$idPersonal;
                $new2Config6->activo='2';
                $new2Config6->borrado='0';
                $new2Config6->fechaini=$fecha;
                $new2Config6->fechafin=$fecha;
                $new2Config6->turno_id=$turno2OpE6;
            $new2Config6->save();

         }

            //Domingo

         if(intval($turno2OpE7)!=0 && intval($turno2OpE7)!=intval($turnoOpE7) &&  $check7E==1)
        {
            $new2Config7 = new Configdia();
                $new2Config7->tipo='1'; 
                $new2Config7->tipodia_id='7';//Tipo Dia del 1 al 7, esto no es editable 
                $new2Config7->personal_id=$idPersonal;
                $new2Config7->activo='2';
                $new2Config7->borrado='0';
                $new2Config7->fechaini=$fecha;
                $new2Config7->fechafin=$fecha;
                $new2Config7->turno_id=$turno2OpE7;
            $new2Config7->save();

        }



        /******************************* Turnos Terceros*********************/




        if(intval($turno3OpE1)!=0 && intval($turno3OpE1)!=intval($turno2OpE1) && intval($turno3OpE1)!=intval($turnoOpE1) &&  $check1E==1)
        {
            $new3Config1 = new Configdia();
                $new3Config1->tipo='1'; 
                $new3Config1->tipodia_id='1';//Tipo Dia del 1 al 7, esto no es editable 
                $new3Config1->personal_id=$idPersonal;
                $new3Config1->activo='3';
                $new3Config1->borrado='0';
                $new3Config1->fechaini=$fecha;
                $new3Config1->fechafin=$fecha;
                $new3Config1->turno_id=$turno3OpE1;
            $new3Config1->save();
        }
            

            //Martes

        if(intval($turno3OpE2)!=0 && intval($turno3OpE2)!=intval($turno2OpE2) && intval($turno3OpE2)!=intval($turnoOpE2) &&  $check2E==1)
        {
            $new3Config2 = new Configdia();
                $new3Config2->tipo='1'; 
                $new3Config2->tipodia_id='2';//Tipo Dia del 1 al 7, esto no es editable 
                $new3Config2->personal_id=$idPersonal;
                $new3Config2->activo='3';
                $new3Config2->borrado='0';
                $new3Config2->fechaini=$fecha;
                $new3Config2->fechafin=$fecha;
                $new3Config2->turno_id=$turno3OpE2;
            $new3Config2->save();

        }

            //Miercoles

        if(intval($turno3OpE3)!=0 && intval($turno3OpE3)!=intval($turno2OpE3) && intval($turno3OpE3)!=intval($turnoOpE3) &&  $check3E==1)
        {
            $new3Config3 = new Configdia();
                $new3Config3->tipo='1'; 
                $new3Config3->tipodia_id='3';//Tipo Dia del 1 al 7, esto no es editable 
                $new3Config3->personal_id=$idPersonal;
                $new3Config3->activo='3';
                $new3Config3->borrado='0';
                $new3Config3->fechaini=$fecha;
                $new3Config3->fechafin=$fecha;
                $new3Config3->turno_id=$turno3OpE3;
            $new3Config3->save();

        }

            //Jueves

        if(intval($turno3OpE4)!=0 && intval($turno3OpE4)!=intval($turno2OpE4) && intval($turno3OpE4)!=intval($turnoOpE4) &&  $check4E==1)
        {
            $new3Config4 = new Configdia();
                $new3Config4->tipo='1'; 
                $new3Config4->tipodia_id='4';//Tipo Dia del 1 al 7, esto no es editable 
                $new3Config4->personal_id=$idPersonal;
                $new3Config4->activo='3';
                $new3Config4->borrado='0';
                $new3Config4->fechaini=$fecha;
                $new3Config4->fechafin=$fecha;
                $new3Config4->turno_id=$turno3OpE4;
            $new3Config4->save();

        }

            //Viernes

        if(intval($turno3OpE5)!=0 && intval($turno3OpE5)!=intval($turno2OpE5) && intval($turno3OpE5)!=intval($turnoOpE5) &&  $check5E==1)
        {
            $new3Config5 = new Configdia();
                $new3Config5->tipo='1'; 
                $new3Config5->tipodia_id='5';//Tipo Dia del 1 al 7, esto no es editable 
                $new3Config5->personal_id=$idPersonal;
                $new3Config5->activo='3';
                $new3Config5->borrado='0';
                $new3Config5->fechaini=$fecha;
                $new3Config5->fechafin=$fecha;
                $new3Config5->turno_id=$turno3OpE5;
            $new3Config5->save();

        }

        //Sabado
        
        if(intval($turno3OpE6)!=0 && intval($turno3OpE6)!=intval($turno2OpE6) && intval($turno3OpE6)!=intval($turnoOpE6) &&  $check6E==1)
        {
            
            $new3Config6 = new Configdia();
                $new3Config6->tipo='1'; 
                $new3Config6->tipodia_id='6';//Tipo Dia del 1 al 7, esto no es editable 
                $new3Config6->personal_id=$idPersonal;
                $new3Config6->activo='3';
                $new3Config6->borrado='0';
                $new3Config6->fechaini=$fecha;
                $new3Config6->fechafin=$fecha;
                $new3Config6->turno_id=$turno3OpE6;
            $new3Config6->save();

         }

            //Domingo

         if(intval($turno3OpE7)!=0 && intval($turno3OpE7)!=intval($turno2OpE7) && intval($turno3OpE7)!=intval($turnoOpE7) &&  $check7E==1)
        {
            $new3Config7 = new Configdia();
                $new3Config7->tipo='1'; 
                $new3Config7->tipodia_id='7';//Tipo Dia del 1 al 7, esto no es editable 
                $new3Config7->personal_id=$idPersonal;
                $new3Config7->activo='3';
                $new3Config7->borrado='0';
                $new3Config7->fechaini=$fecha;
                $new3Config7->fechafin=$fecha;
                $new3Config7->turno_id=$turno3OpE7;
            $new3Config7->save();

        }





            $result='1';
         $msj='Modificación de Turnos Realizada con Éxito';
         $selector='';

            return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);


    }

     public function prueba(Request $request)
    {


        $idPersonal=$request->id;

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



        $id2Config1=$request->id2Config1;
        $id2Config2=$request->id2Config2;
        $id2Config3=$request->id2Config3;
        $id2Config4=$request->id2Config4;
        $id2Config5=$request->id2Config5;
        $id2Config6=$request->id2Config6;
        $id2Config7=$request->id2Config7;



        $turno2OpE1=$request->turno2OpE1;
        $turno2OpE2=$request->turno2OpE2;
        $turno2OpE3=$request->turno2OpE3;
        $turno2OpE4=$request->turno2OpE4;
        $turno2OpE5=$request->turno2OpE5;
        $turno2OpE6=$request->turno2OpE6;
        $turno2OpE7=$request->turno2OpE7;


        $id3Config1=$request->id3Config1;
        $id3Config2=$request->id3Config2;
        $id3Config3=$request->id3Config3;
        $id3Config4=$request->id3Config4;
        $id3Config5=$request->id3Config5;
        $id3Config6=$request->id3Config6;
        $id3Config7=$request->id3Config7;



        $turno3OpE1=$request->turno3OpE1;
        $turno3OpE2=$request->turno3OpE2;
        $turno3OpE3=$request->turno3OpE3;
        $turno3OpE4=$request->turno3OpE4;
        $turno3OpE5=$request->turno3OpE5;
        $turno3OpE6=$request->turno3OpE6;
        $turno3OpE7=$request->turno3OpE7;

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


        /***********************Primer Turno ***********************/

       $editConfig1 = Configdia::find($idConfig1);

        //var_dump( $editConfig1);

        if ($editConfig1 != null){
        $editConfig1->borrado='1';
        $editConfig1->fechafin=$fecha;
        $editConfig1->save();
        }

        $editConfig2 = Configdia::find($idConfig2);

        if ($editConfig2 != null){
        $editConfig2->borrado='1';
        $editConfig2->fechafin=$fecha;
        $editConfig2->save();
        }

        $editConfig3 = Configdia::find($idConfig3);

        if ($editConfig3 != null){
        $editConfig3->borrado='1';
        $editConfig3->fechafin=$fecha;
        $editConfig3->save();
        }

        $editConfig4 = Configdia::find($idConfig4);

        if ($editConfig4 != null){
        $editConfig4->borrado='1';
        $editConfig4->fechafin=$fecha;
        $editConfig4->save();
         }

        $editConfig5 = Configdia::find($idConfig5);

        if ($editConfig5 != null){
        $editConfig5->borrado='1';
        $editConfig5->fechafin=$fecha;
        $editConfig5->save();
        }

        $editConfig6 = Configdia::find($idConfig6);

        if ($editConfig6 != null){
        $editConfig6->borrado='1';
        $editConfig6->fechafin=$fecha;
        $editConfig6->save();
        }

        $editConfig7 = Configdia::find($idConfig7);

        if ($editConfig7 != null){
        $editConfig7->borrado='1';
        $editConfig7->fechafin=$fecha;
        $editConfig7->save();
        }



        



        $result='1';
        $msj='prueba';
        $selector=$idConfig1;



        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);

    }

    public function altabaja($id,$estado)
    {
        $result='1';
        $msj='';
        $selector='';

        $updatePersonal = Personal::findOrFail($id);
        $updatePersonal->activo=$estado;
        $updatePersonal->save();

        if(strval($estado)=="0"){
            $msj='El Personal fue Desactivado exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='El Personal fue Activado exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);

    }


    public function destroy($id)
    {
        $result='1';
        $msj='1';



        $borrarPersonal = Personal::findOrFail($id);
        $borrarPersonal->borrado='1';
        $borrarPersonal->save();

        $msj='Personal seleccionado eliminado exitosamente';


        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
