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

use App\Justificacion;
use Validator;
use Auth;
use DB;
use Storage;


class LicenciaController extends Controller
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

        $fecha=date("d/m/Y");
            $mesActual=date("m");
        $yearActual=date("Y");


            $imagenPerfil="";



        $modulo="replicencias";

        return view('reporteJustificacion.index',compact('modulo','tipouser','imagenPerfil','mesActual','yearActual','fecha'));

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

                ->leftjoin('datoscolegios', 'datoscolegios.institucion_id', '=', 'institucions.id')
                ->where('institucions.activo','1')
                ->where('institucions.borrado','0')
                ->where('institucions.id',$idIE)
                ->orderBy('institucions.id')
                ->select('institucions.id','institucions.nombre as nombre','institucions.direccion','institucions.telefono','institucions.correo','institucions.activo','institucions.tipo','datoscolegios.id as idcolegio','datoscolegios.zona','datoscolegios.codigomod','datoscolegios.clave8','datoscolegios.modalidad')->get();
            }
            else{
               // $institucion=Institucion::where('activo','1')->where('borrado','0')->where('tipo','2')->get()->paginate(35);;
                 $institucion=DB::table('institucions')
                ->leftjoin('datoscolegios', 'datoscolegios.institucion_id', '=', 'institucions.id')
                ->where('institucions.activo','1')
                ->where('institucions.borrado','0')
                ->orderBy('institucions.id')

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

        return [

            'personals'=>$personals
        ];
    }


        public function buscar(Request $request)
    {
        $idInsti=$request->idInsti;
        $idPersonal=$request->idPersonal;
        $tipofecha=$request->tipofecha;
        $fechaini=$request->fechaini;
        $fechafin=$request->fechafin;

        $andInsti="";
        $andPersonal="";
        $andFecha="";

        $fecha=date("Y-m-d");

        $year=date("Y");

        $month=date("m");




        if($idInsti!="0")
        {
            $andInsti=" and t.institucion_id=='".$idInsti."'' ";
        }
        if($idPersonal!="0")
        {
            $andPersonal=" and t.id='".$idPersonal."' ";
        }
        if($tipofecha=="0")
        {
            $andFecha=" and (j.fechaini<='".$fecha."' or j.fechafin>='".$fecha."') ";

        }elseif ($tipofecha=="1") {
            
            $andFecha=" and ((year(j.fechaini)<='".$year."' and month(j.fechaini)<='".$month."') or (year(j.fechafin)>='".$year."' and month(j.fechafin)>='".$month."')) ";

        }elseif ($tipofecha=="2") {
            
            $andFecha=" and (year(j.fechaini)<='".$year."' or year(j.fechafin)>='".$year."') ";

        }elseif ($tipofecha=="3") {
            
            $andFecha=" ";

        }
        elseif ($tipofecha=="4") {
            
            $andFecha=" and (j.fechaini<='".$fechaini."' or j.fechafin>='".$fechaini."' or j.fechaini<='".$fechafin."' or j.fechafin>='".$fechafin."' ) ";

        }

        $sql="select p.doc as dni, concat(p.apellidos,' ',p.nombres) as nombres, t.cargo, t.ley,
        j.nombre as motivo, j.descripcion, j.rutafile, j.namefile , j.fechaini, j.fechafin
        from personas p
        inner join personals t on t.persona_id=p.id
        inner join justificacions j on j.personals_id=t.id
        where j.borrado='0' ".$andInsti." ".$andPersonal." ".$andFecha.";";


        $datos=DB::select($sql);

        $result="0";
        $msj="No se Encontraron Registros";

        foreach ($datos as $key => $value) {
            $result="1";
        $msj="Datos Listos para Imprimir";
        }


        return [

            'datos'=>$datos,
            'result'=>$result,
            'msj'=>$msj
        ]; 

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
