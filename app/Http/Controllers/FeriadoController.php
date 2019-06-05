<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Feriado;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Personal;
use App\Tipouser;
use App\User;
use Datetime;



class FeriadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index1()
{
    if(accesoUser([1,2])){

        $iduser=Auth::user()->id;
        $idtipouser=Auth::user()->tipouser_id;
        $tipouser=Tipouser::find($idtipouser);

            $imagenPerfil="";


        $modulo="feriado";
        return view('feriados.index',compact('modulo','tipouser','imagenPerfil'));
    }
    else
        {
            return view('adminlte::home');           
        }

   
}


    public function index(Request $request)
    {
         $buscar=$request->busca;
         $feriados = Feriado::where('nombre', 'like', '%'.$buscar.'%')->orWhere('years', $buscar)->orderBy('years','desc')->orderBy('fecha')->paginate(10);

        return [
            'pagination'=>[
                'total'=> $feriados->total(),
                'current_page'=> $feriados->currentPage(),
                'per_page'=> $feriados->perPage(),
                'last_page'=> $feriados->lastPage(),
                'from'=> $feriados->firstItem(),
                'to'=> $feriados->lastItem(),
            ],
            'feriados'=>$feriados
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
        $newFeriado=$request->newFeriado;
        $newFecha=$request->newFecha;


        $input1  = array('newFeriado' => $newFeriado);
        $reglas1 = array('newFeriado' => 'required');

         $input3  = array('newFecha' => $newFecha);
        $reglas3 = array('newFecha' => 'required');

        $input2  = array('newFecha' => $newFecha);
        $reglas2 = array('newFecha' => 'unique:feriados,fecha'.',1,borrado');

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);
         $validator3 = Validator::make($input3, $reglas3);

         $result='1';
         $msj='';
         $selector='';

         if ($validator1->fails())
        {
            $result='0';
            $msj='Debe completar el Nombre del Feriado';
            $selector='txtnombre';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='La fecha consignada ya se encuentra registrada';
            $selector='txtfecha';
        }
        elseif ($validator3->fails()) {
            $result='0';
            $msj='Debe consignar una fecha';
            $selector='txtfecha';
        }
        else{

        

  $date = DateTime::createFromFormat("Y-m-d", $newFecha);

        $year=intval($date->format("Y"));

            $feriado = new Feriado();

             $feriado->nombre=$newFeriado;
                $feriado->fecha=$newFecha;
                $feriado->years=$year;
                $feriado->activo='1';
                $feriado->borrado='0';

            $feriado->save();





            $msj='Nueva Feriado Registrado con éxito';
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
        $newFeriado=$request->nombre;
        $newFecha=$request->fecha;


        $input1  = array('newFeriado' => $newFeriado);
        $reglas1 = array('newFeriado' => 'required');

         $input3  = array('newFecha' => $newFecha);
        $reglas3 = array('newFecha' => 'required');

        $input2  = array('newFecha' => $newFecha);
       // $reglas2 = array('newFecha' => 'unique:feriados,fecha'.',1,borrado');
        $reglas2 = array('area' => 'unique:feriados,fecha,'.$id.',id,borrado,0');

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);
         $validator3 = Validator::make($input3, $reglas3);

         $result='1';
         $msj='';
         $selector='';

         if ($validator1->fails())
        {
            $result='0';
            $msj='Debe completar el Nombre del Feriado';
            $selector='txtnombreE';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='La fecha consignada ya se encuentra registrada';
            $selector='txtfechaE';
        }
        elseif ($validator3->fails()) {
            $result='0';
            $msj='Debe consignar una fecha';
            $selector='txtfechaE';
        }
        else{

        

  $date = DateTime::createFromFormat("Y-m-d", $newFecha);

        $year=intval($date->format("Y"));

            $feriado = Feriado::findOrFail($id);

             $feriado->nombre=$newFeriado;
                $feriado->fecha=$newFecha;
                $feriado->years=$year;

            $feriado->save();





            $msj='Feriado Modificado con éxito';
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
        $result='1';
        $msj='1';


        $borrararea = Feriado::destroy($id);
        //$task->delete();


        $msj='Registro eliminado exitosamente';
        

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
