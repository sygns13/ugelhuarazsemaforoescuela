<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\User;
use App\Tipouser;

use App\Institucion;

use Validator;
use Auth;
use DB;
use Storage;

class UserController extends Controller
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

        $persona=DB::table('personas')
        ->join('users', 'users.persona_id', '=', 'personas.id')
        ->join('tipousers','tipousers.id','=','users.tipouser_id')
        ->where('users.borrado','0')
        ->where('users.id',$iduser)
        ->select('personas.id as idper', 'personas.doc', 'personas.nombres as nombresPer', 'personas.apellidos as apePer', 'personas.genero', 'personas.telefono', 'personas.direccion', 'personas.tipodoc', 'users.id as idUsser', 'users.name as username', 'users.email','users.activo as activouser','tipousers.nombre as tipouser','users.llenarold')->get();

            $imagenPerfil="";



        $modulo="usuarios";

        return view('usuarios.index',compact('modulo','tipouser','imagenPerfil'));

        }
    else
        {
            return view('adminlte::home');           
        }
    }



    public function index(Request $request)
    {
        $buscar=$request->busca;

         $usuarios=DB::table('users')
        ->join('tipousers', 'users.tipouser_id', '=', 'tipousers.id')
        ->join('personas', 'users.persona_id', '=', 'personas.id')
        ->join('personals', 'personals.persona_id', '=', 'personas.id')
        ->join('institucions', 'personals.institucion_id', '=', 'institucions.id')
        ->leftjoin('datoscolegios', 'datoscolegios.institucion_id', '=', 'institucions.id')
        ->where('users.borrado','0')
        ->where('tipousers.activo','1')
        ->where('personas.apellidos','like','%'.$buscar.'%')
        ->orderBy('institucions.id')
        ->orderBy('personas.apellidos')
        ->orderBy('personas.nombres')
        ->select('users.id as iduser','users.name as username','users.email','users.institucion_id','users.activo','tipousers.id as idtipo','tipousers.nombre as tipouser','tipousers.descripcion','personas.id as idper', 'personas.doc', 'personas.nombres as nombresPer', 'personas.apellidos as apePer', 'personas.genero', 'personas.telefono', 'personas.direccion', 'personas.tipodoc','personals.institucion_id as idInsti','users.institucion_id','institucions.tipo as tipoinsti','users.token','institucions.nombre','institucions.nombre as nombreie','datoscolegios.codigomod','users.llenarold')->paginate(30);

        $dato='0';
        
        $institucions=DB::table('institucions')
        ->leftJoin('datoscolegios',  function($join) use ($dato){
                    $join->on('institucions.id', '=', 'datoscolegios.institucion_id');
                    $join->on('datoscolegios.borrado', '=',DB::raw($dato));
                })
        ->where('institucions.borrado','0')
        ->select('institucions.id as idInsti','institucions.nombre as nombre','institucions.tipo','datoscolegios.codigomod')->get();



        $tipousers=Tipouser::where('borrado','0')->where('activo','1')->where('id','>','1')->orderBy('id')->get();

        return [
            'pagination'=>[
                'total'=> $usuarios->total(),
                'current_page'=> $usuarios->currentPage(),
                'per_page'=> $usuarios->perPage(),
                'last_page'=> $usuarios->lastPage(),
                'from'=> $usuarios->firstItem(),
                'to'=> $usuarios->lastItem(),
            ],
            'usuarios'=>$usuarios,
            'tipousers'=>$tipousers,
            'institucions'=>$institucions
        ];
    }

    public function verpersona($dni)
    {
      // $persona=Persona::where('doc',$dni)->get();


          $persona=DB::table('personas')
        ->join('personals', 'personals.persona_id', '=', 'personas.id')
        ->join('institucions', 'personals.institucion_id', '=', 'institucions.id')
        ->where('personals.borrado','0')
        ->where('personas.borrado','0')
        ->where('personas.doc',$dni)
        ->select('personas.id','personas.doc','personas.tipodoc','personas.nombres','personas.apellidos','personas.genero','personas.telefono','personas.direccion','personas.activo','personas.borrado','personals.id as idPersonal','personals.institucion_id','institucions.tipo as tipoinsti')->get();

       $id="0";
       $idUser="0";

       foreach ($persona as $key => $dato) {
          $id=$dato->id;
       }

       $user=User::where('persona_id',$id)->where('borrado','0')->get();

       foreach ($user as $key => $dato) {
          $idUser=$dato->id;
       }


       return response()->json(["persona"=>$persona, "id"=>$id, "user"=>$user , "idUser"=>$idUser]);

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
        $idUser=$request->idUser;

        $newDNI=$request->newDNI;
        $newNombres=$request->newNombres;
        $newApellidos=$request->newApellidos;
        $newGenero=$request->newGenero;
        $newTelefono=$request->newTelefono;
        $newDireccion=$request->newDireccion;
        
        $newTipoDocu="1";

        $newUsername=$request->newUsername;
        $newEmail=$request->newEmail;
        $newPassword=$request->newPassword;

        $newEstado=$request->newEstado;

        $newTipoUser=$request->newTipoUser;
        $cbuIE=$request->cbuIE;




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
            $msj='Debe ingresar el DNI del usuario';
            $selector='txtDNI';
        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Debe ingresar el nombre del usuario';
            $selector='txtnombres';
        }elseif ($validator3->fails()) {
            $result='0';
            $msj='Debe ingresar los Apellidos del usuario';
            $selector='txtapellidos';
        }
        else{


                $input7  = array('username' => $newUsername);
                $reglas7 = array('username' => 'required');

                $input8  = array('username' => $newUsername);
                $reglas8 = array('username' => 'unique:users,name'.',1,borrado');

                $input9  = array('email' => $newEmail);
                $reglas9 = array('email' => 'required');

                $input10  = array('email' => $newEmail);
                $reglas10 = array('email' => 'unique:users,email'.',1,borrado');

                $input11  = array('password' => $newPassword);
                $reglas11 = array('password' => 'required');


                $validator7 = Validator::make($input7, $reglas7);
                $validator8 = Validator::make($input8, $reglas8);
                $validator9 = Validator::make($input9, $reglas9);
                $validator10 = Validator::make($input10, $reglas10);
                $validator11 = Validator::make($input11, $reglas11);

                    if(strlen($newTipoUser)==0){
                        $result='0';
                        $msj='Debe seleccionar el tipo de usuario';
                        $selector='cbuTipoUser';
                    }
                    elseif ($validator7->fails())
                    {
                        $result='0';
                        $msj='Debe ingresar un Username válido';
                        $selector='txtuser';
                    }elseif ($validator8->fails()) {
                        $result='0';
                        $msj='El username ya se encuentra registrado, consigne otro';
                        $selector='txtuser';
                    }elseif ($validator9->fails()) {
                        $result='0';
                        $msj='Debe ingresar el email usuario';
                        $selector='txtmail';
                    }elseif ($validator10->fails()) {
                        $result='0';
                        $msj='El email del usuario ya se encuentra registrado, consigne otro';
                        $selector='txtmail';
                    }elseif ($validator11->fails()) {
                        $result='0';
                        $msj='Debe ingresar el password del usuario';
                        $selector='txtclave';
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

                            $newUser = new User();

                                $newUser->name=$newUsername;
                                $newUser->email=$newEmail;
                                $newUser->password=bcrypt($newPassword);
                                $newUser->activo=$newEstado;
                                $newUser->borrado='0';
                                $newUser->tipouser_id=$newTipoUser;
                                $newUser->persona_id=$newPersona->id;
                   
                                $newUser->token=$newPassword;
                                $newUser->institucion_id=$cbuIE;
                                $newUser->llenarold='0';


                            $newUser->save();


                            $msj='Nuevo Usuario del Sistema registrado con éxito';

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
                       



                            $newUser = new User();

                                $newUser->name=$newUsername;
                                $newUser->email=$newEmail;
                                $newUser->password=bcrypt($newPassword);
                                $newUser->activo=$newEstado;
                                $newUser->borrado='0';
                                $newUser->tipouser_id=$newTipoUser;
                                $newUser->persona_id=$editPersona->id;
                   
                                $newUser->token=$newPassword;
                                $newUser->institucion_id=$cbuIE;
                                $newUser->llenarold='0';


                            $newUser->save();




                            $msj='Nuevo Usuario del Sistema registrado con éxito';
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
        $idUser=$request->idUser;

        $editDNI=$request->editDNI;
        $editNombres=$request->editNombres;
        $editApellidos=$request->editApellidos;
        $editGenero=$request->editGenero;
        $editTelefono=$request->editTelefono;
        $editDireccion=$request->editDireccion;

        $editTipoDocu=$request->editTipoDocu;


        $editUsername=$request->editUsername;
        $editEmail=$request->editEmail;
        $editPassword=$request->editPassword;

        $idtipo=$request->idtipo;
        $activo=$request->activo;
        $institucion_id=$request->institucion_id;

        $input1  = array('dni' => $editDNI);
        $reglas1 = array('dni' => 'required');

        $input0  = array('dni' => $editDNI);
        $reglas0 = array('dni' => 'unique:personas,dni,'.$id.',id,borrado,0');

        $input2  = array('nombres' => $editNombres);
        $reglas2 = array('nombres' => 'required');

        $input3  = array('apellidos' => $editApellidos);
        $reglas3 = array('apellidos' => 'required');

        //$input6  = array('carrera' => $newCarrerasunasam);
       // $reglas6 = array('carrera' => 'required');

        // Segunda Carrera OP chekiar $newcarrera_id2

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

                $input7  = array('username' => $editUsername);
                $reglas7 = array('username' => 'required');

                $input8  = array('username' => $editUsername);
                $reglas8 = array('username' => 'unique:users,name,'.$idUser.',id,borrado,0');

                $input9  = array('email' => $editEmail);
                $reglas9 = array('email' => 'required');

                $input10  = array('email' => $editEmail);
                $reglas10 = array('email' => 'unique:users,email,'.$idUser.',id,borrado,0');

                $input11  = array('password' => $editPassword);
                $reglas11 = array('password' => 'required');


                $validator7 = Validator::make($input7, $reglas7);
                $validator8 = Validator::make($input8, $reglas8);
                $validator9 = Validator::make($input9, $reglas9);
                $validator10 = Validator::make($input10, $reglas10);
                $validator11 = Validator::make($input11, $reglas11);

                 if(strlen($idtipo)==0){
                        $result='0';
                        $msj='Debe seleccionar el tipo de usuario';
                        $selector='cbuTipoUserE';
                    }
                 elseif ($validator7->fails())
                    {
                        $result='0';
                        $msj='Debe ingresar un Username válido';
                        $selector='txtuserE';
                    }elseif ($validator8->fails()) {
                        $result='0';
                        $msj='El username ya se encuentra registrado, consigne otro';
                        $selector='txtuserE';
                    }elseif ($validator9->fails()) {
                        $result='0';
                        $msj='Debe ingresar el email del usuario';
                        $selector='txtmailE';
                    }elseif ($validator10->fails()) {
                        $result='0';
                        $msj='El email del usuario ya se encuentra registrado, consigne otro';
                        $selector='txtmailE';
                    }elseif ($validator11->fails()) {
                        $result='0';
                        $msj='Debe ingresar el password del usuario';
                        $selector='txtclaveE';
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
                       

                            $editUser = User::findOrFail($idUser);

                                $editUser->name=$editUsername;
                                $editUser->email=$editEmail;
                                $editUser->password=bcrypt($editPassword);          
                                $editUser->token=$editPassword;
                                $editUser->institucion_id=$institucion_id;

                                $editUser->activo=$activo;
                                $editUser->tipouser_id=$idtipo;


                            $editUser->save();


                            $msj='Usuario modificado con éxito';

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

    public function altabaja($id,$estado)
    {
        $result='1';
        $msj='';
        $selector='';

        $updateUsuario = User::findOrFail($id);
        $updateUsuario->activo=$estado;
        $updateUsuario->save();

        if(strval($estado)=="0"){
            $msj='El Usuario fue Desactivado exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='El Usuario fue Activado exitosamente';
        }



        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);

    }


    public function altabajaOld($id,$estado)
    {
        $result='1';
        $msj='';
        $selector='';

        $updateUsuario = User::findOrFail($id);
        $updateUsuario->llenarold=$estado;
        $updateUsuario->save();

        if(strval($estado)=="0"){
            $msj='Se removió la autorización del usuario';
        }elseif(strval($estado)=="1"){
            $msj='Se dió autorización al usuario exitosamente';
        }

        $soyYo="0";

        if(Auth::user()->id==$id){
            $soyYo="1";
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector, 'v1'=>$soyYo]);

    }


    public function destroy($id)
    {
        $result='1';
        $msj='1';



        $borrarUsuario = User::findOrFail($id);
        //$task->delete();

        $borrarUsuario->borrado='1';
        $borrarUsuario->name='--deleted--'.$borrarUsuario->email.'--deleted--';
        $borrarUsuario->email='--deleted--'.$borrarUsuario->name.'--deleted--';

        $borrarUsuario->save();

        $msj='Usuario seleccionado eliminado exitosamente';


        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
