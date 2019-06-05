<?php echo $__env->make('personals.componentes', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script type="text/javascript">
         let app = new Vue({
    el: '#app',
    data:{
        tipouserPerfil:'<?php echo e($tipouser->nombre); ?>',
        userPerfil:'<?php echo e(Auth::user()->name); ?>',
        mailPerfil:'<?php echo e(Auth::user()->email); ?>',
        imgPerfil:'<?php echo e($imagenPerfil); ?>',
        noPerfil:'noPerfil.png',
        titulo:"Personal",
        subtitulo:"Gestión",
        subtitle2:false,
        subtitulo2:"",
        divloader0:true,
        divloader1:false,
        divloader2:false,
        divloader3:false,
        divloader4:false,
        divloader5:false,
        divloader6:false,
        divloader7:false,
        divloader8:false,
        divloader9:false,
        divloader10:false,
        divtitulo:true,
        classTitle:'fa fa-users',
        classMenu0:'',
        classMenu1:'',
        classMenu2:'',
        classMenu3:'',
        classMenu4:'',
        classMenu5:'',
        classMenu6:'active',
        classMenu7:'',
        classMenu8:'',
        classMenu9:'',
        classMenu10:'',

        divpersonal:true,

        usuarios: [],
        personals: [],
        tipousers: [],
        persona:[],
        user:[],
        institucions:[],
        
        errors:[],
       fillPersona:{'id':'', 'doc':'', 'nombres':'', 'apellidos':'', 'genero':'', 'telefono':'', 'direccion':'', 'tipodocu':'1','tipoinsti':''},

        filluser:{'id':'', 'name':'', 'email':'', 'password':'', 'tipouser_id':'', 'activo':'', 'token':'','institucion_id':''},

        fillPersonal:{'id':'', 'ley':'', 'cargo':'', 'institucion_id':'','activo':''},

        pagination: {
        'total': 0,
                'current_page': 0,
                'per_page': 0,
                'last_page': 0,
                'from': 0,
                'to': 0
                },
                offset: 9,

        buscar:'',
        divNuevoUsuario:false,
        divEditUsuario:false,

        newDNI:'',
        newNombres:'',
        newApellidos:'',
        newGenero:'0',
        newTelefono:'',
        newDireccion:'',

        newTipoDocu:'1',

        newTipoUser:'',
        newEstado:'1',

        newUsername:'',
        newEmail:'',
        newPassword:'',


        divloaderNuevo:false,

        divloaderEdit:false,

        divloaderEditUsuario:false,

        divloaderEditSeccion2:false,
 

        formularioCrear:false,
        mostrarPalenIni:false,

        validated:'0',

        idPersona:'0',
        idUser:'0',
        tipoUser:'',

        thispage:'1',

        thispage2:'1',

        institucion_id:'',
        tipoinsti:'',

        nombreie:'',
        codmod:'',


        ley:'',
        cargo:'',
        idPersonal:'',

         turnos:[],

        turnoOp:'1',

        check1:'1',
        check2:'1',
        check3:'1',
        check4:'1',
        check5:'1',

        check6:'0',
        check7:'0',



        turnoOpE1:'',
        turnoOpE2:'',
        turnoOpE3:'',
        turnoOpE4:'',
        turnoOpE5:'',

        turnoOpE6:'',
        turnoOpE7:'',

        check1E:1,
        check2E:1,
        check3E:1,
        check4E:1,
        check5E:1,

        check6E:1,
        check7E:1,

        idConfig1:'',
        idConfig2:'',
        idConfig3:'',
        idConfig4:'',
        idConfig5:'',
        idConfig6:'',
        idConfig7:'',

        turns:[],

        divcontentLicencia:false,

        personaL:'',
        cargoL:'',
        personal_id:'',
        dniL:'',


        imagen : null,
        archivo : null,
        newNombreArchivo : '',
        uploadReady: true,

        imagenE : null,
        archivoE : null,
        uploadReadyE: false,

        oldImg:'',
        oldFile:'',

        file:'',
        image:'',
        nameAdjunto:'',
        urlAdjunto:'',
        iflink:false,
        nameAdjuntoE:'',

        licencias:[],

        newTitulo:'',
        newFecIni:'',
        newFecFin:'',

        content: '',
        contentE: '',

        divNuevaInformacion:false,

        fillinformacion:{'id':'', 'nombre':'', 'descripcion':'', 'rutafile':'', 'fecha':'', 'personals_id':'', 'fechaini':'', 'fechafin':'','archivonombre':'','oldFile':''},


    },
    created:function () {
        this.getPersonals(this.thispage);
    },
    mounted: function () {
        this.divloader0=false;

        if(this.imgPerfil.length>0){
            $(".imgPerfil").attr("src","<?php echo e(asset('/img/perfil/')); ?>"+"/"+this.imgPerfil);
        }
        else{
            $(".imgPerfil").attr("src","<?php echo e(asset('/img/perfil/')); ?>"+"/"+this.noPerfil);
        }
 
    },
    computed:{
        isActived: function(){
            return this.pagination.current_page;
        },
        pagesNumber: function () {
            if(!this.pagination.to){
                return [];
            }

            var from=this.pagination.current_page - this.offset 
            var from2=this.pagination.current_page - this.offset 
            if(from<1){
                from=1;
            }

            var to= from2 + (this.offset*2); 
            if(to>=this.pagination.last_page){
                to=this.pagination.last_page;
            }

            var pagesArray = [];
            while(from<=to){
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        }
    },

     
 methods: {
 getPersonals: function (page) {
            var busca=this.buscar;
            var urlUsuarios = 'personals?page='+page+'&busca='+busca;

            axios.get(urlUsuarios).then(response=>{

                this.personals= response.data.personals.data;
                

                this.$nextTick(function () {
                app.turnos=response.data.turnos;
                })

                this.institucions= response.data.institucions;
                this.pagination= response.data.pagination;
                this.turns= response.data.turns;
                this.mostrarPalenIni=true;

                if(this.personals.length==0 && this.thispage!='1'){
                    var a = parseInt(this.thispage) ;
                    a--;
                    this.thispage=a.toString();
                    this.changePage(this.thispage);
                }
            })
        },
        changePage:function (page) {
            this.pagination.current_page=page;

            if(this.divpersonal){
            this.getPersonals(page);
            this.thispage=page;
             }
            else{
                this.getLicencias(page,this.personal_id);
                this.thispage2=page;
            }
        },
        buscarBtn: function () {

            if(this.divpersonal){
            this.getPersonals();
            this.thispage='1';
            }
            else{
                this.getLicencias(1,this.personal_id);
                this.thispage2='1';
            }

        },
        nuevoUsuario:function () {
            this.divNuevoUsuario=true;
            this.divloaderEditUsuario=false;

            this.$nextTick(function () {
            this.cancelFormUsuario();
          })
            
        },
        cerrarFormUsuario: function () {
            this.divNuevoUsuario=false;
            this.cancelFormUsuario();
        },
        cancelFormUsuario: function () {
            this.validated='0';
            this.$nextTick(function () {
            $('#txtDNI').focus();
            })
            this.newDNI='';
            this.newNombres='';
            this.newApellidos='';
            this.newGenero='0';
            this.newTelefono='';
            this.newDireccion='';
            this.newTipoDocu='1';


            this.formularioCrear=false;


            this.newEstado='1';
            this.ley='';
            this.cargo='';

            this.divEditUsuario=false;

         $('#txtnombres').focus();
         $('#cbuIE').select2();
         $('#cbuLey').select2();
         $('#cbuCargos').select2();
         

            this.$nextTick(function () {
            $('#cbuIE').val('').trigger('change');
            $('#cbuLey').val('').trigger('change');
            $('#cbuCargos').val('').trigger('change');
            })


        },
        pressNuevoDNI: function (dni) {

            if(dni.length!=8){
                alertify.error('Complete los 08 dígitos correspondientes del DNI');
            }
            else{

                var url = 'personals/verpersona/'+dni;
                axios.get(url).then(response=>{
                this.idPersonal=response.data.idPer;
                
                if(this.idPersonal=="0")
                    {
                this.idPersona=response.data.id;
                this.persona=response.data.persona;

                if(this.idPersona!='0'){
                    $.each(this.persona, function( index, dato ) {

                        app.newDNI=dato.doc;
                        app.newNombres=dato.nombres;
                        app.newApellidos=dato.apellidos;
                        app.newGenero=dato.genero;
                        app.newTelefono=dato.telefono;
                        app.newDireccion=dato.direccion;

                    });


                    this.$nextTick(function () {
                        this.formularioCrear=true;
                        this.$nextTick(function () {

                     $('#cbuIE').select2();
                     $('#cbuLey').select2();
                     $('#cbuCargos').select2();
                     

                        this.$nextTick(function () {
                        $('#cbuIE').val('').trigger('change');
                        $('#cbuLey').val('').trigger('change');
                        $('#cbuCargos').val('').trigger('change');
                        })
        
                             this.validated='1';
                             $('#txtcodigo').focus();

                            })
                            })

                }else{


                this.formularioCrear=true;
                this.$nextTick(function () {
                     this.validated='1';
                     $('#txtnombres').focus();

                     $('#cbuIE').select2();
                     $('#cbuLey').select2();
                     $('#cbuCargos').select2();
                     

                        this.$nextTick(function () {
                        $('#cbuIE').val('').trigger('change');
                        $('#cbuLey').val('').trigger('change');
                        $('#cbuCargos').val('').trigger('change');
                        })

                })
                }


            this.turnoOp='1';
            this.check1='1';
            this.check2='1';
            this.check3='1';
            this.check4='1';
            this.check5='1';
            this.check6='0';
            this.check7='0';


                }
                else{
                     swal({
                      title: 'Personal Registrado',
                      text: 'Ya se encuentra registrado el personal con el DNI: '+dni,
                      type: 'info',
                      confirmButtonText: 'Aceptar'
                    });

                     this.cancelFormUsuario();
                }

                });

            
                
               
            }
            

        },

        createUsuario:function () {
            var url='personals';

            $("#btnGuardar").attr('disabled', true);
            $("#btnCancel").attr('disabled', true);
            $("#btnClose").attr('disabled', true);

            this.divloaderNuevo=true;

            var cbuIE=$("#cbuIE").val();
            var cbuLey=$("#cbuLey").val();
            var cbuCargos=$("#cbuCargos").val();


            var data = new  FormData();

            data.append('idPersona', this.idPersona);
            data.append('idPersonal', this.idPersonal);
            data.append('newDNI', this.newDNI);
            data.append('newNombres', this.newNombres);
            data.append('newApellidos', this.newApellidos);
            data.append('newGenero', this.newGenero);
            data.append('newTelefono', this.newTelefono);
            data.append('newDireccion', this.newDireccion);

            data.append('idturno', this.turnoOp);
            data.append('check1', this.check1);
            data.append('check2', this.check2);
            data.append('check3', this.check3);
            data.append('check4', this.check4);
            data.append('check5', this.check5);
            data.append('check6', this.check6);
            data.append('check7', this.check7);

            data.append('cbuIE', cbuIE);
            data.append('cbuLey', cbuLey);
            data.append('cbuCargos', cbuCargos);

            data.append('newEstado', this.newEstado);
            
            //const config = { headers: { 'Content-Type': 'multipart/form-data' } };


            axios.post(url,data).then(response=>{

                $("#btnGuardar").removeAttr("disabled");
                $("#btnCancel").removeAttr("disabled");
                $("#btnClose").removeAttr("disabled");
                this.divloaderNuevo=false;

                if(response.data.result=='1'){
                    this.getPersonals(this.thispage);
                    this.errors=[];
                    this.cerrarFormUsuario();
                    toastr.success(response.data.msj);
                }else{
                    if(response.data.result=='2'){  

                      $('#'+response.data.selector).select2('open');
                      toastr.error(response.data.msj);
                    }
                      else{
                        $('#'+response.data.selector).focus();
                        toastr.error(response.data.msj);
                      }
                }
            }).catch(error=>{
                this.errors=error.response.data
            })
        },
        borrarUsuario:function (personal) {
              swal({
                  title: '¿Estás seguro?',
                  text: "¿Desea eliminar el personal seleccionado? -- Nota: Este proceso no se podrá revertir",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminar'
                }).then(function () {

                            var url = 'personals/'+personal.idpersonal;
                            axios.delete(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getPersonals(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },

        editUsuario:function (personal) {

            this.fillPersona.id=personal.idper;
            this.fillPersona.doc=personal.doc;
            this.fillPersona.nombres=personal.nombresPer;
            this.fillPersona.apellidos=personal.apePer;
            this.fillPersona.genero=personal.genero;
            this.fillPersona.telefono=personal.telefono;
            this.fillPersona.direccion=personal.direccion;
            this.fillPersona.tipodocu=personal.tipodoc;
            this.fillPersona.tipoinsti=personal.tipoinsti;

            if(this.fillPersona.telefono=='null' || this.fillPersona.telefono==null){
                this.fillPersona.telefono='';
            }
            if(this.fillPersona.direccion=='null' || this.fillPersona.direccion==null){
                this.fillPersona.direccion='';
            }




            this.fillPersonal.id=personal.idpersonal;
            this.fillPersonal.ley=personal.ley;
            this.fillPersonal.cargo=personal.cargo;
            this.fillPersonal.institucion_id=personal.idInsti;

            this.fillPersonal.activo=personal.activo;


             

            this.divNuevoUsuario=false;
            this.divEditUsuario=true;
            this.divloaderEdit=false;

            this.$nextTick(function () {
                //$('#cbuIEEdit').select2();

                     $('#cbuIEEdit').select2();
                     $('#cbuLeyE').select2();
                     $('#cbuCargosE').select2();
                     

            this.$nextTick(function () {
            $('#cbuIEEdit').val(this.fillPersonal.institucion_id).trigger('change');
            $('#cbuLeyE').val(this.fillPersonal.ley).trigger('change');
            $('#cbuCargosE').val(this.fillPersonal.cargo).trigger('change');
            })
            
            this.validated='1';
            
            $('#txtnombresE').focus();
            })
                

        },
        cerrarFormUsuarioE: function(){

            this.divEditUsuario=false;

            this.$nextTick(function () {
            this.fillPersona={'id':'', 'doc':'', 'nombres':'', 'apellidos':'', 'genero':'', 'telefono':'', 'direccion':'', 'tipodocu':'1','tipoinsti':''};
            this.fillPersonal={'id':'', 'ley':'', 'cargo':'', 'institucion_id':'','activo':''};
          })

        },
        updateUsuario:function (idPer,idUser) {


            if($("#cbuIEEdit").val()!=null){
                this.fillPersonal.institucion_id=$("#cbuIEEdit").val();
            }

             if($("#cbuLeyE").val()!=null ){
                this.fillPersonal.ley=$("#cbuLeyE").val();
            }

            if($("#cbuCargosE").val()!=null ){
                this.fillPersonal.cargo=$("#cbuCargosE").val();
            }


        var data = new  FormData();

        data.append('idPersona', this.fillPersona.id);
        data.append('idPersonal', this.fillPersonal.id);

        data.append('editDNI', this.fillPersona.doc);
        data.append('editNombres', this.fillPersona.nombres);
        data.append('editApellidos', this.fillPersona.apellidos);
        data.append('editGenero',  this.fillPersona.genero);
        data.append('editTelefono', this.fillPersona.telefono);
        data.append('editDireccion', this.fillPersona.direccion);
        data.append('editTipoDocu', this.fillPersona.tipodocu);


        data.append('ley', this.fillPersonal.ley);
        data.append('cargo', this.fillPersonal.cargo);
        data.append('instis',  this.fillPersonal.institucion_id);

        data.append('idtipo', this.fillPersonal.tipouser_id);
        data.append('institucion_id', this.fillPersonal.institucion_id);
        data.append('activo', this.fillPersonal.activo);

        data.append('_method', 'PUT');


           var url="personals/"+this.fillPersonal.id;
            $("#btnSaveE").attr('disabled', true);
            $("#btnCloseE").attr('disabled', true);
            this.divloaderEdit=true;

            axios.post(url, data).then(response=>{

                $("#btnSaveE").removeAttr("disabled");
                $("#btnCloseE").removeAttr("disabled");
                this.divloaderEdit=false;
                
                if(response.data.result=='1'){   
                this.getPersonals(this.thispage);
                this.cerrarFormUsuarioE();
                toastr.success(response.data.msj);

                }else{
                    if(response.data.result=='2'){  

                      $('#'+response.data.selector).select2('open');
                      toastr.error(response.data.msj);
                    }
                      else{
                        $('#'+response.data.selector).focus();
                        toastr.error(response.data.msj);
                      }
                }

            }).catch(error=>{
                this.errors=error.response.data
            })
        },
        bajaUsuario:function (personal) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si se desactiva el personal, No podrá registrar su asistencia, ni justificaciones mientras se encuentre desactivado",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, desactivar'
                }).then(function () {

                            var url = 'personals/altabaja/'+personal.idpersonal+'/0';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getPersonals(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        altaUsuario:function (personal) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si activa el personal, podrá realziar registros de asistencias y justificaciones  de él nuevamente",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, Activar'
                }).then(function () {

                            var url = 'personals/altabaja/'+personal.idpersonal+'/1';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getPersonals(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },



        turnosMethod:function (per) {
            $.each(app.personals,function (i) {

                if(per.idpersonal==app.personals[i].idpersonal)

                    {


                        //console.log('lunes');
                        app.check1E=app.turnos[i][0].activo;
                        app.turnoOpE1=app.turnos[i][0].idturnos;
                        app.idConfig1=app.turnos[i][0].idconfig;
                    
                        //console.log('lunes');
                        app.check2E=app.turnos[i][1].activo;
                        app.turnoOpE2=app.turnos[i][1].idturnos;
                        app.idConfig2=app.turnos[i][1].idconfig;
                   
                        //console.log('lunes');
                        app.check3E=app.turnos[i][2].activo;
                        app.turnoOpE3=app.turnos[i][2].idturnos;
                        app.idConfig3=app.turnos[i][2].idconfig;
                    
                        //console.log('lunes');
                        app.check4E=app.turnos[i][3].activo;
                        app.turnoOpE4=app.turnos[i][3].idturnos;
                        app.idConfig4=app.turnos[i][3].idconfig;
                  
                        //console.log('lunes');
                        app.check5E=app.turnos[i][4].activo;
                        app.turnoOpE5=app.turnos[i][4].idturnos;
                        app.idConfig5=app.turnos[i][4].idconfig;
                    
                        //console.log('lunes');
                        app.check6E=app.turnos[i][5].activo;
                        app.turnoOpE6=app.turnos[i][5].idturnos;
                        app.idConfig6=app.turnos[i][5].idconfig;
                    
                        //console.log('lunes');
                        app.check7E=app.turnos[i][6].activo;
                        app.turnoOpE7=app.turnos[i][6].idturnos;
                        app.idConfig7=app.turnos[i][6].idconfig;
                     }
                
            });


            this.fillPersonal.id=per.idpersonal;
            this.fillPersonal.cargo=per.cargo;
            this.fillPersona.nombres=per.nombresPer;
            this.fillPersona.apellidos=per.apePer;
            this.fillPersona.doc=per.doc;


            $("#boxTituloGES2").text('Personal: '+per.apePer+', '+per.nombresPer);
            $("#boxTituloES2").text('Cargo: '+per.doc);

            $("#modalEditSeccion2").modal('show');

            this.$nextTick(function () {
           $("#cbuTurno1E").focus();
          })

        },

        updateSeccion2:function (id) {
            var url="personals/EditTurnos";

            $("#btnSaveESec2").attr('disabled', true);
            $("#btnCancelESec2").attr('disabled', true);
            this.divloaderEditSeccion2=true;


            var data = new  FormData();

            data.append('id', this.fillPersonal.id);

            data.append('idConfig1', app.idConfig1);
            data.append('idConfig2', app.idConfig2);
            data.append('idConfig3', app.idConfig3);
            data.append('idConfig4', app.idConfig4);
            data.append('idConfig5', app.idConfig5);
            data.append('idConfig6', app.idConfig6);
            data.append('idConfig7', app.idConfig7);

            data.append('turnoOpE1', app.turnoOpE1);
            data.append('turnoOpE2', app.turnoOpE2);
            data.append('turnoOpE3', app.turnoOpE3);
            data.append('turnoOpE4', app.turnoOpE4);
            data.append('turnoOpE5', app.turnoOpE5);
            data.append('turnoOpE6', app.turnoOpE6);
            data.append('turnoOpE7', app.turnoOpE7);

            data.append('check1E', app.check1E);
            data.append('check2E', app.check2E);
            data.append('check3E', app.check3E);
            data.append('check4E', app.check4E);
            data.append('check5E', app.check5E);
            data.append('check6E', app.check6E);
            data.append('check7E', app.check7E);

           axios.post(url, data).then(response=>{

                $("#btnSaveESec2").removeAttr("disabled");
                $("#btnCancelESec2").removeAttr("disabled");
                this.divloaderEditSeccion2=false;
                
                if(response.data.result=='1'){   
                app.getPersonals(app.thispage);
                //CKEDITOR.instances['editorE'].setData("");
                this.errors=[];
                $("#modalEditSeccion2").modal('hide');
                toastr.success(response.data.msj);

                }else{

                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                 
                }

            }).catch(error=>{
                this.errors=error.response.data
            })
            

        },



        impFicha:function (personal) {

            

             this.fillPersona.id=personal.idper;
            this.fillPersona.doc=personal.doc;
            this.fillPersona.nombres=personal.nombresPer;
            this.fillPersona.apellidos=personal.apePer;
            this.fillPersona.genero=personal.genero;
            this.fillPersona.telefono=personal.telefono;
            this.fillPersona.direccion=personal.direccion;
            this.fillPersona.tipodocu=personal.tipodoc;
            this.fillPersona.tipoinsti=personal.tipoinsti;

            if(this.fillPersona.telefono=='null' || this.fillPersona.telefono==null){
                this.fillPersona.telefono='';
            }
            if(this.fillPersona.direccion=='null' || this.fillPersona.direccion==null){
                this.fillPersona.direccion='';
            }




            this.fillPersonal.id=personal.idpersonal;
            this.fillPersonal.ley=personal.ley;
            this.fillPersonal.cargo=personal.cargo;
            this.fillPersonal.institucion_id=personal.idInsti;

            this.fillPersonal.activo=personal.activo;



            this.nombreie=personal.nombreie;
            this.codmod=personal.codigomod;

            this.$nextTick(function () {


            this.$nextTick(function () {

            $('#modalFicha').modal(); 
          })
          })

            
            

              
        },
        Imprimir:function (usuario) {
            $("#FichaUsuario").printArea();
        },

























        detalle:function (personal) {
              this.divloader2=true;
              this.divpersonal=false;
              this.subtitle2=true;
              this.subtitulo2="Gestión de Licencias, Permisos y Vacaciones";
              this.personaL=personal.apePer+', '+personal.nombresPer;
              this.dniL=personal.doc;
              this.cargoL=personal.cargo;
              this.personal_id=personal.idpersonal;

              this.getLicencias(this.thispage2,personal.idpersonal);
              this.$nextTick(function () {
                this.divloader2=false;
                this.divcontentLicencia=true;
              });
        },
        volverPrincipal(){
            this.divloader2=true;
            this.divcontentLicencia=false;
            this.getPersonals(this.thispage);
            this.$nextTick(function () {
              this.divloader2=false;
              this.subtitle2=false;
              this.subtitulo2="";
              this.divpersonal=true;
              });
        },

        getLicencias: function (page,idPersonal) {
            var busca=this.buscar;
            var url = 'justificacion?page='+page+'&busca='+busca+'&idPersonal='+idPersonal;

            axios.get(url).then(response=>{
                this.licencias= response.data.licencias.data;
                this.pagination= response.data.pagination;

                if(this.divcontentCarrera){
                    if(this.licencias.length==0 && this.thispage2!='1'){
                    var a = parseInt(this.thispage2) ;
                    a--;
                    this.thispage2=a.toString();
                    this.changePage(this.thispage2);
                    }
                }
            })
        },

        nuevaInformacion:function () {
            this.divNuevaInformacion=true;
            this.$nextTick(function () {
            this.cancelFormInformacion();
          })
            
        },
        cerrarFormInformacion: function () {
            
            this.cancelFormInformacion();
            this.$nextTick(() => {
            this.divNuevaInformacion=false;
            })
        },

        cancelFormInformacion: function () {

          $('#txttitulo').focus();
            this.newTitulo='';
            this.newOrden='';
            
            this.estadoContenido='1';

            this.newNombreArchivo='';
            
            this.newFecIni='';
            this.newFecFin='';
        
        /*$("#archivo").fileinput({language: "es",  
        allowedFileExtensions:['jpg', 'gif', 'png', 'jpe', 'jpeg','JPG', 'GIF', 'PNG', 'JPE', 'JPEG'],
        'showUpload':false,  
        'previewFileType':'any', 
        minFileCount: 1,
        maxFileCount: 1});*/

        // $(".fileinput-remove-button").hide();

        this.imagen=null;
        this.archivo=null;
        this.uploadReady = false
        this.$nextTick(() => {
          this.uploadReady = true;
          $('#txttitulo').focus();
          CKEDITOR.instances['editor'].setData("");
        })
       // $(".fileinput-remove-button").click();


        },

        getArchivo(event){
                //Asignamos la imagen a  nuestra data

                if (!event.target.files.length)
                {
                  this.archivo=null;
                }
                else{
                this.archivo = event.target.files[0];
                }
            },

         createInformacion:function () {
            var url='justificacion';
            $("#btnGuardar").attr('disabled', true);
            $("#btnCancel").attr('disabled', true);
            $("#btnClose").attr('disabled', true);
            this.divloaderNuevo=true;

            var data = new  FormData();

           data.append('nombreArchivo', this.newNombreArchivo);
            data.append('titulo', this.newTitulo);
            data.append('desc', CKEDITOR.instances['editor'].getData());
            data.append('personal_id', this.personal_id);
            data.append('archivo', this.archivo);

            data.append('newFecIni', this.newFecIni);
            data.append('newFecFin', this.newFecFin);

            const config = { headers: { 'Content-Type': 'multipart/form-data' } };

            /*var formData = new FormData($("#formulario")[0]);
            console.log(formData);*/
    
            axios.post(url,data, config).then(response=>{
                //console.log(response.data);

                $("#btnGuardar").removeAttr("disabled");
                $("#btnCancel").removeAttr("disabled");
                $("#btnClose").removeAttr("disabled");
                this.divloaderNuevo=false;

                if(response.data.result=='1'){
                    toastr.success(response.data.msj);
                    this.cerrarFormInformacion();
                    this.getLicencias(this.thispage2,this.personal_id);


                }else{                  
                        $('#'+response.data.selector).focus();
                        toastr.error(response.data.msj);                   
                }
            }).catch(error=>{
                this.errors=error.data
               // console.log('error: '+this.errors)
            })
        },

        borrarInformacion:function (informacion) {
              swal({
                  title: '¿Estás seguro?',
                  text: "¿Desea eliminar el Registro Seleccionado? -- Nota: Si elimina el registro seleccionado, no se podrá revertir esta acción",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminar'
                }).then(function () {

                            var url = 'justificacion/'+informacion.id;
                            axios.delete(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getLicencias(app.thispage2,app.personal_id);
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },

         getArchivoE(event){
                //Asignamos la imagen a  nuestra data

                if (!event.target.files.length)
                {
                  this.archivoE=null;
                }
                else{
                this.archivoE = event.target.files[0];
                }
            },

        editInformacion:function (informacion) {

            this.uploadReadyE=false;
          this.$nextTick(() => {
            this.archivoE=null;
            this.uploadReadyE=true;
            this.$nextTick(() => {
                
      
             });
          });
            this.fillinformacion.id=informacion.id;
            this.fillinformacion.titulo=informacion.nombre;
            this.fillinformacion.fechaini=informacion.fechaini;            
            this.fillinformacion.fechafin=informacion.fechafin;

            this.fillinformacion.fechafin=informacion.fechafin;
            this.fillinformacion.archivonombre=informacion.namefile;





            if(informacion.descripcion != null){
                CKEDITOR.instances['editorE'].setData(informacion.descripcion);
            }
            else{
                CKEDITOR.instances['editorE'].setData("");
            }
            
            this.oldFile=informacion.rutafile;


            $("#boxTitulo").text('Motivo: '+informacion.nombre);
            $("#modalEditar").modal('show');

            this.$nextTick(function () {
           $("#txtordenE").focus();
          })
        },

        updateInformacion:function (id) {
            var url="justificacion/"+id;
            $("#btnSaveE").attr('disabled', true);
            $("#btnCancelE").attr('disabled', true);
            this.divloaderEdit=true;

            this.fillinformacion.descripcion=CKEDITOR.instances['editorE'].getData();
            this.fillinformacion.oldFile= this.oldFile;

            var data = new  FormData();

            data.append('id', this.fillinformacion.id);
            data.append('titulo', this.fillinformacion.titulo);
            data.append('desc', this.fillinformacion.descripcion);

            data.append('archivo', this.archivoE);
            data.append('nombreArchivo', this.fillinformacion.archivonombre);

            data.append('oldfile', this.fillinformacion.oldFile);

            data.append('newFecIni', this.fillinformacion.fechaini);
            data.append('newFecFin', this.fillinformacion.fechafin);

            data.append('personal_id', this.personal_id);

              data.append('_method', 'PUT');
         

            const config = { headers: { 'Content-Type': 'multipart/form-data' } };


           

           axios.post(url, data, config).then(response=>{

                $("#btnSaveE").removeAttr("disabled");
                $("#btnCancelE").removeAttr("disabled");
                this.divloaderEdit=false;
                
                if(response.data.result=='1'){   
                this.getLicencias(this.thispage2,this.personal_id);
                this.fillinformacion={'id':'', 'nombre':'', 'descripcion':'', 'rutafile':'', 'fecha':'', 'personals_id':'', 'fechaini':'', 'fechafin':'','archivonombre':'','oldFile':''};
                //CKEDITOR.instances['editorE'].setData("");
                this.errors=[];
                $("#modalEditar").modal('hide');
                toastr.success(response.data.msj);

                }else{

                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                 
                }

            }).catch(error=>{
                this.errors=error.response.data
            })
            

        },

        pasfechaVista:function(date) 
        {
    date=date.slice(-2)+'/'+date.slice(-5,-3)+'/'+date.slice(0,4);

    return date;
        },


    }

   
       
});
</script>