<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Persona;
use App\User;
use App\Tipouser;

use App\Justificacion;
use App\Institucion;
use App\Personal;
use App\Configdia;

use App\Tipodia;
use App\Turno;



use Validator;
use Auth;
use DB;
use Storage;

class JustificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $buscar=$request->busca;
        $idPersonal=$request->idPersonal;

        $licencias=Justificacion::where('personals_id',$idPersonal)->where('nombre', 'like', '%'.$buscar.'%')->where('borrado','0')->orderBy('id')->paginate(10);

        return [
            'pagination'=>[
                'total'=> $licencias->total(),
                'current_page'=> $licencias->currentPage(),
                'per_page'=> $licencias->perPage(),
                'last_page'=> $licencias->lastPage(),
                'from'=> $licencias->firstItem(),
                'to'=> $licencias->lastItem(),
            ],
            'licencias'=>$licencias
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
        ini_set('memory_limit','256M');
        

        $nombreArchivo="";


        $titulo=$request->titulo;
        $desc=$request->desc;

        $personal_id=$request->personal_id;

        $newFecIni=$request->newFecIni;
        $newFecFin=$request->newFecFin;


        $archivo="";
        $file = $request->archivo;
        $segureFile=0;

        


         $result='1';
         $msj='';
         $selector='';


        if($request->hasFile('archivo')){



            $nombreArchivo=$request->nombreArchivo;

            $aux2=date('d-m-Y').'-'.date('H-i-s').'-'. $personal_id;
            $input2  = array('archivo' => $file) ;
            $reglas2 = array('archivo' => 'required|file:1,20480');
            $validatorF = Validator::make($input2, $reglas2);

            $inputNA  = array('archivonombre' => $nombreArchivo);
            $reglasNA = array('archivonombre' => 'required');
            $validatorNA = Validator::make($inputNA, $reglasNA);

          

            if ($validatorF->fails())
            {

            $segureFile=1;
            $msj="El archivo adjunto ingresado tiene una extensión no válida, ingrese otro archivo o limpie el formulario";
            $result='0';
            $selector='archivo2';
            }
            elseif($validatorNA->fails()){
                $segureFile=1;
                $msj="Si va a registrar un archivo adjunto, debe de ingresar un nombre válido con el que se verá en el sistema";
                $result='0';
                $selector='txtArchivoAdjunto';
            }
            else
            {
                $nombre2=$file->getClientOriginalName();
                $extension2=$file->getClientOriginalExtension();
                $nuevoNombre2=$aux2.".".$extension2;
                $subir2=Storage::disk('infoFile')->put($nuevoNombre2, \File::get($file));

                if($extension2=="pdf" || $extension2=="doc" || $extension2=="docx" || $extension2=="xls" || $extension2=="xlsx" || $extension2=="ppt" || $extension2=="pptx" || $extension2=="PDF" || $extension2=="DOC" || $extension2=="DOCX" || $extension2=="XLS" || $extension2=="XLSX" || $extension2=="PPT" || $extension2=="PTTX")
                {

                if($subir2){
                    $archivo=$nuevoNombre2;
                }
                else{
                    $msj="Error al subir el archivo adjunto, intentelo nuevamente luego";
                    $segureFile=1;
                    $result='0';
                    $selector='archivo';
                }
                }
                else {
                    $segureFile=1;
                    $msj="El archivo adjunto ingresado tiene una extensión no válida, ingrese otro archivo o limpie el formulario";
                    $result='0';
                    $selector='archivo2';
                }
            }

        }

        if($segureFile==1){
     
            Storage::disk('infoFile')->delete($archivo);
        }
        else
        {

        
        $input1  = array('titulo' => $titulo);
        $reglas1 = array('titulo' => 'required');


         $validator1 = Validator::make($input1, $reglas1);

         $input2  = array('newFecIni' => $newFecIni);
        $reglas2 = array('newFecIni' => 'required');


         $validator2 = Validator::make($input2, $reglas2);

         $input3  = array('newFecFin' => $newFecFin);
        $reglas3 = array('newFecFin' => 'required');


         $validator3 = Validator::make($input3, $reglas3);


        

        if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el motivo de la Licencia, Permiso o Vacaciones';
            $selector='txttitulo';

        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='Debe ingresar la fecha de Inicio';
            $selector='txtfecIni';

        }
        elseif ($validator3->fails())
        {
            $result='0';
            $msj='Debe ingresar la Fecha Final';
            $selector='txtFecFin';

        }
        else{
            $fecha=date('Y-m-d');

                $newJustificacion = new Justificacion();
                $newJustificacion->nombre=$titulo;
                $newJustificacion->descripcion=$desc;
                $newJustificacion->rutafile=$archivo;
              
   
                $newJustificacion->activo='1';
                $newJustificacion->borrado='0';

                $newJustificacion->estado='1';
                $newJustificacion->fecha=$fecha;

                $newJustificacion->personals_id=$personal_id;
                $newJustificacion->fechaini=$newFecIni;
                $newJustificacion->fechafin=$newFecFin;
                $newJustificacion->namefile=$nombreArchivo;


            $newJustificacion->save();

            $msj='Nuevo Contenido Informativo Registrado con Éxito';
        }

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

/*

            data.append('id', this.fillinformacion.id);
            data.append('titulo', this.fillinformacion.titulo);
            data.append('desc', this.fillinformacion.descripcion);

            data.append('archivo', this.archivoE);
            data.append('nombreArchivo', this.fillinformacion.archivonombre);

            data.append('oldfile', this.fillinformacion.oldFile);

            data.append('newFecIni', this.fillinformacion.fechaini);
            data.append('newFecFin', this.fillinformacion.fechafin);

*/

        $id=$request->id;
        $titulo=$request->titulo;
        $desc=$request->desc;


        $archivo="";
        $file = $request->archivo;
        $segureFile=0;

        $nombreArchivo=$request->nombreArchivo;


         $result='1';
         $msj='';
         $selector='';

        $newFecIni=$request->newFecIni;
        $newFecFin=$request->newFecFin;
        $personal_id=$request->personal_id;


         $oldFile=$request->oldfile;



if($request->hasFile('archivo')){



            

            $aux2=date('d-m-Y').'-'.date('H-i-s').'-'.$personal_id;
            $input2  = array('archivo' => $file) ;
            $reglas2 = array('archivo' => 'required|file:1,20480');
            $validatorF = Validator::make($input2, $reglas2);

            $inputNA  = array('archivonombre' => $nombreArchivo);
            $reglasNA = array('archivonombre' => 'required');
            $validatorNA = Validator::make($inputNA, $reglasNA);

          

            if ($validatorF->fails())
            {

            $segureFile=1;
            $msj="El archivo adjunto ingresado tiene una extensión no válida, ingrese otro archivo o limpie el formulario";
            $result='0';
            $selector='archivo2';
            }
            elseif($validatorNA->fails()){
                $segureFile=1;
                $msj="Si va a registrar un archivo adjunto, debe de ingresar un nombre válido con el que se verá en el sistema";
                $result='0';
                $selector='txtArchivoAdjuntoE';
            }
            else
            {
                $nombre2=$file->getClientOriginalName();
                $extension2=$file->getClientOriginalExtension();
                $nuevoNombre2=$aux2.".".$extension2;
                $subir2=Storage::disk('infoFile')->put($nuevoNombre2, \File::get($file));

                if($extension2=="pdf" || $extension2=="doc" || $extension2=="docx" || $extension2=="xls" || $extension2=="xlsx" || $extension2=="ppt" || $extension2=="pptx" || $extension2=="PDF" || $extension2=="DOC" || $extension2=="DOCX" || $extension2=="XLS" || $extension2=="XLSX" || $extension2=="PPT" || $extension2=="PTTX")
                {

                if($subir2){
                    $archivo=$nuevoNombre2;
                    Storage::disk('infoFile')->delete($oldFile);
                }
                else{
                    $msj="Error al subir el archivo adjunto, intentelo nuevamente luego";
                    $segureFile=1;
                    $result='0';
                    $selector='archivoE';
                }
                }
                else {
                    $segureFile=1;
                    $msj="El archivo adjunto ingresado tiene una extensión no válida, ingrese otro archivo o limpie el formulario";
                    $result='0';
                    $selector='archivo2E';
                }
            }

        }

        if($segureFile==1){
     
            Storage::disk('infoFile')->delete($archivo);
        }
        else
        {


        $input1  = array('titulo' => $titulo);
        $reglas1 = array('titulo' => 'required');

         $validator1 = Validator::make($input1, $reglas1);

         $input2  = array('newFecIni' => $newFecIni);
        $reglas2 = array('newFecIni' => 'required');


         $validator2 = Validator::make($input2, $reglas2);

         $input3  = array('newFecFin' => $newFecFin);
        $reglas3 = array('newFecFin' => 'required');


         $validator3 = Validator::make($input3, $reglas3);


        

        if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el título del Contenido Informativo '.$request->oldImg;
            $selector='txttituloE';

        }
                elseif ($validator2->fails())
        {
            $result='0';
            $msj='Debe ingresar la fecha de Inicio';
            $selector='txtfecIniE';

        }
        elseif ($validator3->fails())
        {
            $result='0';
            $msj='Debe ingresar la Fecha Final';
            $selector='txtFecFinE';

        }

        else{

            

            if(strlen($archivo)>0)
            {
            $updateJustificacion = Justificacion::findOrFail($id);
                $updateJustificacion->nombre=$titulo;
                $updateJustificacion->descripcion=$desc;
                $updateJustificacion->rutafile=$archivo;
                   
                $updateJustificacion->fechaini=$newFecIni;
                $updateJustificacion->fechafin=$newFecFin;

                $updateJustificacion->namefile=$nombreArchivo;

            $updateJustificacion->save();
            }


            elseif(strlen($archivo)==0){
            $updateJustificacion = Justificacion::findOrFail($id);
                $updateJustificacion->nombre=$titulo;
                $updateJustificacion->descripcion=$desc;
                $updateJustificacion->fechaini=$newFecIni;
                $updateJustificacion->fechafin=$newFecFin;
                $updateJustificacion->namefile=$nombreArchivo;

            $updateJustificacion->save();
            }



            $msj='El Registro ha sido modificada con éxito';
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
    public function destroy($id)
    {
        $result='1';
        $msj='1';



        $borrarJustificacion = Justificacion::findOrFail($id);
        //$task->delete();

        $borrarJustificacion->borrado='1';

        $borrarJustificacion->save();

        $msj='Registro eliminado exitosamente';


        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
