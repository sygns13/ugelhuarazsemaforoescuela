<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Departamento;
use App\Provincia;
use App\Distrito;
use App\Institucion;

use Validator;
use Auth;
use DB;
use Storage;
use stdClass;

use App\Persona;
use App\Personal;
use App\Tipouser;
use App\User;

class UgelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index1()
    {
        if(accesoUser([1,2])){

            $modulo="mainUgel";
            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);       
            $imagenPerfil="";

            return view('ugel.index',compact('modulo','imagenPerfil','tipouser'));
        }
        else
        {
            return view('adminlte::home');           
        }
    }
     
    public function index()
    {
        $departamento=Departamento::findOrFail('2');
        $provincia=Provincia::findOrFail('8');
        $distritos=Distrito::where('provincia_id',$provincia->id)->where('activo','1')->where('borrado','0')->get();

        $institucion=Institucion::findOrFail('1');

        return [
            'departamento'=>$departamento,
            'provincia'=>$provincia,
            'distritos'=>$distritos,
            'institucion'=>$institucion
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
        $nombre=$request->nombre;
        $direccion=$request->direccion;
        $telefono=$request->telefono;
        $correo=$request->correo;
        $distritos_id=$request->distritos_id;


        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');


        $input2  = array('distritos_id' => $distritos_id);
        $reglas2 = array('distritos_id' => 'required');


         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);

         $result='1';
         $msj='';
         $selector='';

         if ($validator1->fails())
        {
            $result='0';
            $msj='Debe Ingresar el nombre de la UGEL';
            $selector='txtugel';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Debe seleccionar el distrito donde se encuentra ubicado la UGEL';
            $selector='cbudistrito';
        }
        else{
            $updateUgel = Institucion::findOrFail($id);
                $updateUgel->nombre=$nombre;
                $updateUgel->direccion=$direccion;
                $updateUgel->telefono=$telefono;
                $updateUgel->correo=$correo;
                $updateUgel->distritos_id=$distritos_id;
            $updateUgel->save();

            $msj='Los Datos de la Ugel han sido modificada con éxito';
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
