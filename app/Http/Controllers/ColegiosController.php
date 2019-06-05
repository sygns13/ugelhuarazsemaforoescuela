<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Departamento;
use App\Provincia;
use App\Distrito;
use App\Institucion;
use App\Datoscolegio;

use App\Tipoie;
use App\Tipogestion;
use App\Nivel;

use Validator;
use Auth;
use DB;
use Storage;
use stdClass;

use App\Persona;
use App\Personal;
use App\Tipouser;
use App\User;


class ColegiosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index1()
    {
        if(accesoUser([1,2,3])){

            $modulo="colegios";
            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);       
            $imagenPerfil="";

            return view('colegios.index',compact('modulo','imagenPerfil','tipouser'));
        }
        else
        {
            return view('adminlte::home');           
        }
    }

    public function index(Request $request)
    {   

        $buscar=$request->busca;

        $departamento=Departamento::findOrFail('2');
        $provincia=Provincia::findOrFail('8');
        $distritos=Distrito::where('provincia_id',$provincia->id)->where('activo','1')->where('borrado','0')->get();

        $nivels=Nivel::where('borrado','0')->where('activo','1')->orderBy('id')->get();
        $tipoGes=Tipogestion::where('borrado','0')->where('activo','1')->orderBy('id')->get();
        $tipoIes=Tipoie::where('borrado','0')->where('activo','1')->orderBy('id')->get();

        $iduser=Auth::user()->id;
        $idtipouser=Auth::user()->tipouser_id;
        $tipouser=Tipouser::find($idtipouser);

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
                ->join('distritos', 'institucions.distritos_id', '=', 'distritos.id')
                ->where('institucions.borrado','0')
                ->where('institucions.tipo','2')
                ->where('institucions.id',$idIE)
                ->orderBy('institucions.id')
                ->where('institucions.nombre','like','%'.$buscar.'%')
                ->select('institucions.id','institucions.nombre','institucions.direccion','institucions.telefono','institucions.correo','institucions.activo','institucions.distritos_id','datoscolegios.zona','datoscolegios.codigomod','datoscolegios.clave8','datoscolegios.modalidad','nivels.descripcion as nivel','tipoies.descripcion as tipoie','tipogestions.descripcion as tipogestion','distritos.nombre as distrito','datoscolegios.id as idcoleg','nivels.id as idnivel','tipoies.id as idtipoie','tipogestions.id as idgestions')->paginate(35);
            }
            else{
               // $institucion=Institucion::where('activo','1')->where('borrado','0')->where('tipo','2')->get()->paginate(35);;
                $institucion=DB::table('institucions')
                ->join('datoscolegios', 'datoscolegios.institucion_id', '=', 'institucions.id')
                ->join('nivels', 'datoscolegios.nivel_id', '=', 'nivels.id')
                ->join('tipoies', 'datoscolegios.tipoie_id', '=', 'tipoies.id')
                ->join('tipogestions', 'datoscolegios.tipogestion_id', '=', 'tipogestions.id')
                ->join('distritos', 'institucions.distritos_id', '=', 'distritos.id')
                ->where('institucions.borrado','0')
                ->where('institucions.tipo','2')
                ->where('institucions.nombre','like','%'.$buscar.'%')
                ->orderBy('institucions.id')
                ->select('institucions.id','institucions.nombre','institucions.direccion','institucions.telefono','institucions.correo','institucions.activo','institucions.distritos_id','datoscolegios.zona','datoscolegios.codigomod','datoscolegios.clave8','datoscolegios.modalidad','nivels.descripcion as nivel','tipoies.descripcion as tipoie','tipogestions.descripcion as tipogestion','distritos.nombre as distrito','datoscolegios.id as idcoleg','nivels.id as idnivel','tipoies.id as idtipoie','tipogestions.id as idgestions')->paginate(35);
            }

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
            'departamento'=>$departamento,
            'provincia'=>$provincia,
            'distritos'=>$distritos,
            'nivels'=>$nivels,
            'tipoGes'=>$tipoGes,
            'tipoIes'=>$tipoIes
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
        $idnivel=$request->idnivel;
        $idtipoie=$request->idtipoie;
        $iddistrito=$request->iddistrito;
        $idgestion=$request->idgestion;

        $newIE=$request->newIE;
        $newcodigomod=$request->newcodigomod;
        $newModalidad=$request->newModalidad;
        $newdirec=$request->newdirec;
        $newtelf=$request->newtelf;
        $newmail=$request->newmail;
        $estadoie=$request->estadoie;

        $input1  = array('idnivel' => $idnivel);
        $reglas1 = array('idnivel' => 'required');

        $input2  = array('idtipoie' => $idtipoie);
        $reglas2 = array('idtipoie' => 'required');

        $input3  = array('iddistrito' => $iddistrito);
        $reglas3 = array('iddistrito' => 'required');

        $input4  = array('idgestion' => $idgestion);
        $reglas4 = array('idgestion' => 'required');

        $input5  = array('newIE' => $newIE);
        $reglas5 = array('newIE' => 'required');

        $input6  = array('newIE' => $newIE);
        $reglas6 = array('newIE' => 'unique:institucions,nombre'.',1,borrado');

        $input7  = array('newcodigomod' => $newcodigomod);
        $reglas7 = array('newcodigomod' => 'required');

        $input8  = array('newcodigomod' => $newcodigomod);
        $reglas8 = array('newcodigomod' => 'unique:datoscolegios,codigomod'.',1,borrado');

        $input9  = array('newModalidad' => $newModalidad);
        $reglas9 = array('newModalidad' => 'required');

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);
         $validator3 = Validator::make($input3, $reglas3);
         $validator4 = Validator::make($input4, $reglas4);
         $validator5 = Validator::make($input5, $reglas5);
         $validator6 = Validator::make($input6, $reglas6);
         $validator7 = Validator::make($input7, $reglas7);
         $validator8 = Validator::make($input8, $reglas8);
         $validator9 = Validator::make($input9, $reglas9);

         $result='1';
         $msj='';
         $selector='';

         if($validator1->fails()){
            $result='2';
            $msj='Seleccione un Nivel Válido';
            $selector='cbuNivel';
         }elseif($validator2->fails()){
            $result='2';
            $msj='Seleccione un Tipo de Institución Educativa Válido';
            $selector='cbuTipo';
         }elseif($validator3->fails()){
            $result='2';
            $msj='Seleccione un Distrito Válido';
            $selector='cbudistrito';
         }elseif($validator4->fails()){
            $result='2';
            $msj='Seleccione un Tipo de Gestión Válido';
            $selector='cbuGestion';
         }

         elseif ($validator5->fails())
        {
            $result='0';
            $msj='Debe ingresar el Nombre de la Institución Educativa';
            $selector='txtIE';

        }elseif (1==2) {
            $result='0';
            $msj='La Institución Educativa consignada ya se encuentra registrada';
            $selector='txtIE';
        }

        elseif ($validator7->fails())
        {
            $result='0';
            $msj='Debe ingresar el Código Modular de la Institución Educativa';
            $selector='txtcodmod';

        }elseif ($validator8->fails()) {
            $result='0';
            $msj='El Código Modular consignado ya se encuentra registrado';
            $selector='txtcodmod';
        }

        elseif ($validator9->fails())
        {
            $result='0';
            $msj='Debe ingresar la Modalidad de la Institución Educativa';
            $selector='txtmodalidad';

        }

        else{
            $newInstitucion = new Institucion();
                $newInstitucion->nombre=$newIE;
                $newInstitucion->direccion=$newdirec;
                $newInstitucion->telefono=$newtelf;
                $newInstitucion->correo=$newmail;
   
                $newInstitucion->activo=$estadoie;
                $newInstitucion->borrado='0';
                $newInstitucion->tipo='2';
                $newInstitucion->distritos_id=$iddistrito;
                $newInstitucion->institucion_id='1';

            $newInstitucion->save();


            $newColegio = new Datoscolegio();
                $newColegio->zona='';
                $newColegio->codigomod=$newcodigomod;
                $newColegio->clave8='';
                $newColegio->tipoie_id=$idtipoie;
                $newColegio->tipogestion_id=$idgestion;
                $newColegio->nivel_id=$idnivel;
                $newColegio->institucion_id=$newInstitucion->id;
                $newColegio->modalidad=$newModalidad;

            $newColegio->save();


            $msj='Nueva Institución Educativa creada con éxito';
        }




       //Areaunasam::create($request->all());

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
        $idnivel=$request->idnivel;
        $idtipoie=$request->idtipoie;
        $iddistrito=$request->iddistrito;
        $idgestion=$request->idgestion;

        $nombre=$request->nombre;
        $codigomod=$request->codigomod;
        $modalidad=$request->modalidad;
        $direccion=$request->direccion;
        $telefono=$request->telefono;
        $correo=$request->correo;
        $activo=$request->activo;
        $idcole=$request->idcole;

        $input1  = array('idnivel' => $idnivel);
        $reglas1 = array('idnivel' => 'required');

        $input2  = array('idtipoie' => $idtipoie);
        $reglas2 = array('idtipoie' => 'required');

        $input3  = array('iddistrito' => $iddistrito);
        $reglas3 = array('iddistrito' => 'required');

        $input4  = array('idgestion' => $idgestion);
        $reglas4 = array('idgestion' => 'required');

        $input5  = array('nombre' => $nombre);
        $reglas5 = array('nombre' => 'required');

        $input6  = array('nombre' => $nombre);
        //$reglas6 = array('nombre' => 'unique:institucions,nombre'.',1,borrado');
        $reglas6 = array('nombre' => 'unique:institucions,nombre,'.$id.',id,borrado,0');

        $input7  = array('codigomod' => $codigomod);
        $reglas7 = array('codigomod' => 'required');

        $input8  = array('codigomod' => $codigomod);
        //$reglas8 = array('codigomod' => 'unique:datoscolegios,codigomod'.',1,borrado');
         $reglas8 = array('codigomod' => 'unique:datoscolegios,codigomod,'.$idcole.',id,borrado,0');

        $input9  = array('modalidad' => $modalidad);
        $reglas9 = array('modalidad' => 'required');

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);
         $validator3 = Validator::make($input3, $reglas3);
         $validator4 = Validator::make($input4, $reglas4);
         $validator5 = Validator::make($input5, $reglas5);
         $validator6 = Validator::make($input6, $reglas6);
         $validator7 = Validator::make($input7, $reglas7);
         $validator8 = Validator::make($input8, $reglas8);
         $validator9 = Validator::make($input9, $reglas9);

         $result='1';
         $msj='';
         $selector='';

         if($validator1->fails()){
            $result='2';
            $msj='Seleccione un Nivel Válido';
            $selector='cbuNivelE';
         }elseif($validator2->fails()){
            $result='2';
            $msj='Seleccione un Tipo de Institución Educativa Válido';
            $selector='cbuTipoE';
         }elseif($validator3->fails()){
            $result='2';
            $msj='Seleccione un Distrito Válido';
            $selector='cbudistritoE';
         }elseif($validator4->fails()){
            $result='2';
            $msj='Seleccione un Tipo de Gestión Válido';
            $selector='cbuGestionE';
         }

         elseif ($validator5->fails())
        {
            $result='0';
            $msj='Debe ingresar el Nombre de la Institución Educativa';
            $selector='txtIEE';

        }elseif (1==2) {
            $result='0';
            $msj='La Institución Educativa consignada ya se encuentra registrada en otro registro';
            $selector='txtIEE';
        }

        elseif ($validator7->fails())
        {
            $result='0';
            $msj='Debe ingresar el Código Modular de la Institución Educativa';
            $selector='txtcodmodE';

        }elseif ($validator8->fails()) {
            $result='0';
            $msj='El Código Modular consignado ya se encuentra registrado en otro registro';
            $selector='txtcodmodE';
        }

        elseif ($validator9->fails())
        {
            $result='0';
            $msj='Debe ingresar la Modalidad de la Institución Educativa';
            $selector='txtmodalidadE';

        }

        else{
            $editInstitucion = Institucion::findOrFail($id);
                $editInstitucion->nombre=$nombre;
                $editInstitucion->direccion=$direccion;
                $editInstitucion->telefono=$telefono;
                $editInstitucion->correo=$correo;
   
                $editInstitucion->activo=$activo;

                $editInstitucion->distritos_id=$iddistrito;

            $editInstitucion->save();


            $editColegio = Datoscolegio::findOrFail($idcole);
                $editColegio->codigomod=$codigomod;
                $editColegio->tipoie_id=$idtipoie;
                $editColegio->tipogestion_id=$idgestion;
                $editColegio->nivel_id=$idnivel;
                $editColegio->modalidad=$modalidad;

            $editColegio->save();


            $msj='La Institución Educativa  ha sido modificada con éxito';
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


    public function altabaja($id,$estado)
    {
        $result='1';
        $msj='';
        $selector='';

        $updateIE = Institucion::findOrFail($id);
        $updateIE->activo=$estado;
        $updateIE->save();

        if(strval($estado)=="0"){
            $msj='La Institución Educativa fue Desactivada exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='La Institución Educativa fue Activada exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);

    }

    public function destroy($id)
    {
        $result='1';
        $msj='1';



        $borrarIE = Datoscolegio::findOrFail($id);
        $borrarIE->borrado='1';
        $borrarIE->save();

        $borrarInstitucion = Institucion::findOrFail($borrarIE->institucion_id);
        $borrarInstitucion->borrado='1';
        $borrarInstitucion->save();

        $msj='Institucion Educativa eliminada exitosamente';
        

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
