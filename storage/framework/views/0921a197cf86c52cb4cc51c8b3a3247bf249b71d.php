<script type="text/javascript">

         let app = new Vue({
    el: '#app',
    data:{
        tipouserPerfil:'<?php echo e($tipouser->nombre); ?>',
        userPerfil:'<?php echo e(Auth::user()->name); ?>',
        mailPerfil:'<?php echo e(Auth::user()->email); ?>',
        imgPerfil:'<?php echo e($imagenPerfil); ?>',
        noPerfil:'noPerfil.png',
        content: '',
        contentE: '',

        titulo:"Instituciones Educativas",
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
        classTitle:'fa fa-university',
        classMenu0:'',
        classMenu1:'',
        classMenu2:'active',
        classMenu3:'',
        classMenu4:'',
        classMenu5:'',
        classMenu6:'',
        classMenu7:'',
        classMenu8:'',
        classMenu9:'',
        classMenu10:'',
        classMenu11:'',

        divprincipal:true,
        divgradossec:false,

        departamento: [],
        provincia: [],
        distrito: [],

        tipogestion: [],
        tipoie: [],
        nivel: [],

        institucion: [],
        institucionOld: [],

        carreras: [],
        errors:[],
        fillColegio:{'id':'', 'nombre':'', 'codigomod':'', 'modalidad':'','direccion':'','telefono':'','correo':'','activo':'','idcole':'','idnivel':'','idtipoie':'','iddistrito':'','idgestion':''},

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
        divNuevaCarrera:false,

        newIE:'',
        newcodigomod:'',
        newModalidad:'',
        newdirec:'',
        newtelf:'',
        newmail:'',
        estadoie:'',
        estadoie:'1',

        divloaderNuevo:false,
        divloaderEdit:false,
        formuModal:true,

        informacions:[],
        fillgrados:{'id':'','nombre':'','activo':''},
        fillseccions:{'id':'','nombre':'','cantalumnos':'','activo':'','fechaini':'','fechafin':''},

        divNuevaInformacion:false,

        colegioIE:'',
        codmodIE:'',
        idInsti:'',
        idCole:'',

        grados: [],
        secciones:[],
        numAlumnos:[],


        idIEuser:'',
        newGrado:'',
        estadoGrado:'1',


        newSeccion:'',
        newEstadoSec:'',
        newcantAlum:'',
        newgradID:'',

        divloaderNS:false,

        turnos:[],

        turnoOp:'4',

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

        divloaderEditSeccion:false,
        divloaderEditSeccion2:false,

        thispage:'1',

        thispage2:'1',


    },
    created:function () {
        this.getColegios(this.thispage);
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
        getColegios: function (page) {
            var busca=this.buscar;
            var url = 'colegios?page='+page+'&busca='+busca;

            axios.get(url).then(response=>{
                this.institucion= response.data.institucion.data;
                this.pagination= response.data.pagination;

                this.departamento=response.data.departamento;
                this.provincia=response.data.provincia;
                this.distrito=response.data.distritos;

                this.tipogestion=response.data.tipoGes;
                this.tipoie=response.data.tipoIes;
                this.nivel=response.data.nivels;

                if(this.divprincipal){
                    if(this.institucion.length==0 && this.thispage!='1'){
                    var a = parseInt(this.thispage) ;
                    a--;
                    this.thispage=a.toString();
                    this.changePage(this.thispage);

                    }
                }
            })
        },
        changePage:function (page) {
            this.pagination.current_page=page;

            if(this.divprincipal){
                this.getColegios(page);   
                this.thispage=page;             
            }
            else{
                this.getGradoSeccions(page,this.carrera_id);
                this.thispage2=page;
            }
            
        },
        buscarBtn: function () {
            this.getColegios();
            this.thispage='1';
        },

        nuevaCarrera:function () {
            this.divNuevaCarrera=true;
            this.$nextTick(function () {
            this.cancelFormCarrera();
          })
            
        },
        cerrarFormCarrera: function () {
            this.divNuevaCarrera=false;
            this.cancelFormCarrera();
        },
        cancelFormCarrera: function () {

          $('#txtIE').focus();
            this.newIE='';
            this.newcodigomod='';
            this.newModalidad='';
            this.newdirec='';
            this.newtelf='';
            this.newmail='';
            this.estadoie='';
            this.estadoie='1';

           $('#cbuNivel').select2();
           $('#cbuTipo').select2();
           $('#cbudistrito').select2();
           $('#cbuGestion').select2();

           $('#cbuNivel').val('').trigger('change');
           $('#cbuTipo').val('').trigger('change');
           $('#cbudistrito').val('').trigger('change');
           $('#cbuGestion').val('').trigger('change');
        },
        createCarrera:function () {
            var url='colegios';
            $("#btnGuardar").attr('disabled', true);
            $("#btnCancel").attr('disabled', true);
            $("#btnClose").attr('disabled', true);
            this.divloaderNuevo=true;
            var idnivel=$("#cbuNivel").val();
            var idtipoie=$("#cbuTipo").val();
            var iddistrito=$("#cbudistrito").val();
            var idgestion=$("#cbuGestion").val();

            axios.post(url,{idnivel:idnivel, idtipoie:idtipoie, iddistrito:iddistrito, idgestion:idgestion, newIE:this.newIE, newcodigomod:this.newcodigomod, newModalidad:this.newModalidad, newdirec:this.newdirec, newtelf:this.newtelf, newmail:this.newmail, estadoie:this.estadoie}).then(response=>{
                //console.log(response.data);

                $("#btnGuardar").removeAttr("disabled");
                $("#btnCancel").removeAttr("disabled");
                $("#btnClose").removeAttr("disabled");
                this.divloaderNuevo=false;

                if(response.data.result=='1'){
                    toastr.success(response.data.msj);
                    this.cerrarFormCarrera();
                    this.getColegios(this.thispage);
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
                this.errors=error.data
               // console.log('error: '+this.errors)
            })
        },

        borrarCarrera:function (colegio) {
              swal({
                  title: '¿Estás seguro?',
                  text: "¿Desea eliminar la Institución Educativa Seleccionada? -- Nota: Este proceso no podrá ser revocado.",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminar'
                }).then(function () {

                            var url = 'colegios/'+colegio.idcoleg;
                            axios.delete(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getColegios(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        editCarrera:function (colegio) {

         this.formuModal=false;

          this.$nextTick(function () {
            this.formuModal=true;

            this.$nextTick(function () {
            $('#cbudistritoE').select2();
           $('#cbuNivelE').select2();
           $('#cbuTipoE').select2();
           $('#cbuGestionE').select2();
           this.$nextTick(function () {
           $('#cbudistritoE').val(colegio.distritos_id).trigger('change');
           $('#cbuNivelE').val(colegio.idnivel).trigger('change');
           $('#cbuTipoE').val(colegio.idtipoie).trigger('change');
           $('#cbuGestionE').val(colegio.idgestions).trigger('change');

           $('.select2').css("width","100%");
             });
             });
          });


            this.fillColegio.id=colegio.id;
            this.fillColegio.nombre=colegio.nombre;
            this.fillColegio.codigomod=colegio.codigomod;
            this.fillColegio.modalidad=colegio.modalidad;
            this.fillColegio.direccion=colegio.direccion;
            this.fillColegio.telefono=colegio.telefono;
            this.fillColegio.correo=colegio.correo;
            this.fillColegio.activo=colegio.activo;
            this.fillColegio.idcole=colegio.idcoleg;

            $("#boxTitulo").text('Institución Educativa: '+colegio.nombre);
            $("#modalEditar").modal('show');

            this.$nextTick(function () {
           $("#txtIEE").focus();
          })
        },
        updateCarrera:function (id) {
            var url="colegios/"+id;
            $("#btnSaveE").attr('disabled', true);
            $("#btnCancelE").attr('disabled', true);
            this.divloaderEdit=true;



            this.fillColegio.idnivel= $('#cbuNivelE').val();
            this.fillColegio.idtipoie= $('#cbuTipoE').val();
            this.fillColegio.iddistrito= $('#cbudistritoE').val();
            this.fillColegio.idgestion= $('#cbuGestionE').val();

            axios.put(url, this.fillColegio).then(response=>{

                $("#btnSaveE").removeAttr("disabled");
                $("#btnCancelE").removeAttr("disabled");
                this.divloaderEdit=false;
                
                if(response.data.result=='1'){   
                this.getColegios(this.thispage);
                this.fillColegio={'id':'', 'nombre':'', 'codigomod':'', 'modalidad':'','direccion':'','telefono':'','correo':'','activo':'','idcole':'','idnivel':'','idtipoie':'','iddistrito':'','idgestion':''};
                //CKEDITOR.instances['editorE'].setData("");
                this.errors=[];
                $("#modalEditar").modal('hide');
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
        bajaCarrera:function (colegio) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si se desactiva la Institución Educativa, no se podrán realizar registros de asistencias de esta IE, Tampoco podrán realizar ninguna acción ni iniciar sesión los usuarios pertenecientes a esta IE.",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, desactivar'
                }).then(function () {

                            var url = 'colegios/altabaja/'+colegio.id+'/0';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getColegios(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        altaCarrera:function (colegio) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si activa la Institución Educativa, se podrá realizar el control de asistencia de esta IE, y los usuarios pertenecientes a esta IE podrán iniciar al sistema y realizar sus registros",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, Activar'
                }).then(function () {

                            var url = 'colegios/altabaja/'+colegio.id+'/1';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getColegios(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
















        detalle:function (colegio) {
              this.divloader2=true;
              this.divprincipal=false;
              this.subtitle2=true;
              this.subtitulo2="Gestión de la Institución Educativa: ";
              this.colegioIE=colegio.nombre;
              this.codmodIE=colegio.codigomod;
              this.idInsti=colegio.id;
              this.idCole=colegio.idcoleg;

              this.getGradoSeccions(this.thispage2,colegio.idcoleg);
              this.$nextTick(function () {
                this.divloader2=false;
                this.divgradossec=true;

              });
        },
        volverCarreras(){
            this.divloader2=true;
            this.divgradossec=false;
            this.getColegios(this.thispage);
            this.$nextTick(function () {
              this.divloader2=false;
              this.subtitle2=false;
              this.subtitulo2="";
              this.divprincipal=true;
              });
        },
        getGradoSeccions: function (page,idcoleg) {
            var busca=this.buscar;
            var url = 'grados?page='+page+'&busca='+busca+'&idcoleg='+idcoleg;

            axios.get(url).then(response=>{
                app.grados=response.data.grados;
                this.$nextTick(function () {
                app.secciones=response.data.secciones;
                
                this.$nextTick(function () {
                app.turnos=response.data.turnos;
                app.numAlumnos=response.data.numAlumnos;
                })
                })
                app.turns=response.data.turns;

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

          $('#txtgrado').focus();
            this.newGrado='';          
            this.estadoGrado='1';


        },

        createInformacion:function () {
            var url='grados';
            $("#btnGuardar").attr('disabled', true);
            $("#btnCancel").attr('disabled', true);
            $("#btnClose").attr('disabled', true);
            this.divloaderNuevo=true;

            var data = new  FormData();

            data.append('grado', this.newGrado);
            data.append('estado', this.estadoGrado);
            data.append('colegio_id', this.idCole);


    
            axios.post(url,data).then(response=>{
                //console.log(response.data);

                $("#btnGuardar").removeAttr("disabled");
                $("#btnCancel").removeAttr("disabled");
                $("#btnClose").removeAttr("disabled");
                this.divloaderNuevo=false;

                if(response.data.result=='1'){
                    toastr.success(response.data.msj);
                    this.cerrarFormInformacion();
                    this.getGradoSeccions(this.thispage2,this.idCole);


                }else{                  
                        $('#'+response.data.selector).focus();
                        toastr.error(response.data.msj);                   
                }
            }).catch(error=>{
                this.errors=error.data
               // console.log('error: '+this.errors)
            })
        },
        borrarInformacion:function (grado) {
              swal({
                  title: '¿Estás seguro?',
                  text: "¿Desea eliminar el Grado Seleccionado? -- Nota: Si elimina el gradoo seleccionado, se eliminarán todas las secciones correspondientes a él, este proceso no podrá ser revocado",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminar'
                }).then(function () {

                            var url = 'grados/'+grado.id;
                            axios.delete(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getGradoSeccions(app.thispage2,app.idCole);
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },


            editInformacion:function (grado) {



            this.fillgrados.id=grado.id;
            this.fillgrados.nombre=grado.nombre;
            this.fillgrados.activo=grado.activo;


            $("#boxTitulo").text('Grado: '+grado.nombre);
            $("#modalEditar").modal('show');

            this.$nextTick(function () {
           $("#txtgradoE").focus();
          })
        },
        updateInformacion:function (id) {
            var url="grados/"+id;
            $("#btnSaveE").attr('disabled', true);
            $("#btnCancelE").attr('disabled', true);
            this.divloaderEdit=true;


            var data = new  FormData();

            data.append('id', this.fillgrados.id);
            data.append('grado', this.fillgrados.nombre);
            data.append('estado', this.fillgrados.activo);

              data.append('_method', 'PUT');
         
           

           axios.post(url, data).then(response=>{

                $("#btnSaveE").removeAttr("disabled");
                $("#btnCancelE").removeAttr("disabled");
                this.divloaderEdit=false;
                
                if(response.data.result=='1'){   
                this.getGradoSeccions(this.thispage2,this.idCole);
                this.fillgrados={'id':'','nombre':'','activo':''};
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

        bajaInformacion:function (grado) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si se desactiva el Grado, no se podrán registrar asistencias correspondientes al grado desactivado.",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, desactivar'
                }).then(function () {

                            var url = 'grados/altabaja/'+grado.id+'/0';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getGradoSeccions(app.thispage2,app.idCole);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        altaInformacion:function (grado) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si activa el Grado, se podrán realizar registros de asistencias correspondientes al grado activado.",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, Activar'
                }).then(function () {

                            var url = 'grados/altabaja/'+grado.id+'/1';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getGradoSeccions(app.thispage2,app.idCole);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },















        nuevaSecc:function (grado) {


            this.newSeccion='';
            this.newcantAlum='';
            this.newEstadoSec='1';
            this.newgradID=grado.id;

            this.turnoOp='4';
            this.check1='1';
            this.check2='1';
            this.check3='1';
            this.check4='1';
            this.check5='1';
            this.check6='0';
            this.check7='0';


            $("#boxTitulonSec").text('Grado: '+grado.nombre);
            $("#modalSeccion").modal('show');

            this.$nextTick(function () {
           $("#txtSeccion").focus();
          })
        },

        createSeccion:function () {
            var url="seccion";
            $("#btnSaveNS").attr('disabled', true);
            $("#btnCancelNS").attr('disabled', true);
            this.divloaderNS=true;


            var data = new  FormData();

            data.append('seccion', this.newSeccion);
            data.append('cantAlum', this.newcantAlum);
            data.append('estado', this.newEstadoSec);
            data.append('newgradID', this.newgradID);

            data.append('idturno', this.turnoOp);
            data.append('check1', this.check1);
            data.append('check2', this.check2);
            data.append('check3', this.check3);
            data.append('check4', this.check4);
            data.append('check5', this.check5);
            data.append('check6', this.check6);
            data.append('check7', this.check7);

              //data.append('_method', 'PUT');
         
           

           axios.post(url, data).then(response=>{

                $("#btnSaveNS").removeAttr("disabled");
                $("#btnCancelNS").removeAttr("disabled");
                this.divloaderNS=false;
                
                if(response.data.result=='1'){   
                this.getGradoSeccions(this.thispage2,this.idCole);
                this.errors=[];
                $("#modalSeccion").modal('hide');
                toastr.success(response.data.msj);

                }else{

                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                 
                }

            }).catch(error=>{
                this.errors=error.response.data
            })
            

        },

        borrarSeccion:function (seccion) {
              swal({
                  title: '¿Estás seguro?',
                  text: "¿Desea eliminar la Sección Seleccionada? -- Nota: Si elimina la sección seleccionada, se eliminará el número de matriculados asignados a él, este proceso no podrá ser revocado",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminar'
                }).then(function () {

                            var url = 'seccion/'+seccion.idSec;
                            axios.delete(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getGradoSeccions(app.thispage2,app.idCole);
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },


         editSeccion:function (seccion) {



            this.fillseccions.id=seccion.idSec;
            this.fillseccions.nombre=seccion.seccion;
            this.fillseccions.cantalumnos=seccion.cantalumnos;
            this.fillseccions.activo=seccion.activo;


            $("#boxTituloGES").text('Grado: '+seccion.grado);
            $("#boxTituloES").text('Sección: '+seccion.seccion);

            $("#modalEditSeccion").modal('show');

            this.$nextTick(function () {
           $("#txtSeccionE").focus();
          })
        },
        updateSeccion:function (id) {
            var url="seccion/"+id;

            $("#btnSaveESec").attr('disabled', true);
            $("#btnCancelESec").attr('disabled', true);
            this.divloaderEditSeccion=true;


            var data = new  FormData();

            data.append('id', this.fillseccions.id);
            data.append('seccion', this.fillseccions.nombre);
            data.append('cantalumnos', this.fillseccions.cantalumnos);
            data.append('estado', this.fillseccions.activo);

              data.append('_method', 'PUT');
         
           

           axios.post(url, data).then(response=>{

                $("#btnSaveESec").removeAttr("disabled");
                $("#btnCancelESec").removeAttr("disabled");
                this.divloaderEditSeccion=false;
                
                if(response.data.result=='1'){   
                this.getGradoSeccions(this.thispage2,this.idCole);
                this.fillseccions={'id':'','nombre':'','cantalumnos':'','activo':'','fechaini':'','fechafin':''};
                //CKEDITOR.instances['editorE'].setData("");
                this.errors=[];
                $("#modalEditSeccion").modal('hide');
                toastr.success(response.data.msj);

                }else{

                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                 
                }

            }).catch(error=>{
                this.errors=error.response.data
            })
            

        },



        bajaSeccion:function (seccion) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si se desactiva la Sección, no se podrán registrar asistencias correspondientes a la Sección desactivada.",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, desactivar'
                }).then(function () {

                            var url = 'seccion/altabaja/'+seccion.idSec+'/0';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getGradoSeccions(app.thispage2,app.idCole);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        altaSeccion:function (seccion) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si activa la Sección, podrá realizar registros correspondientes a ella",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, Activar'
                }).then(function () {

                            var url = 'seccion/altabaja/'+seccion.idSec+'/1';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getGradoSeccions(app.thispage2,app.idCole);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },

        turnosMethod:function (seccion) {
            $.each(app.turnos,function (i) {
                if(seccion.idSec==app.turnos[i].idSec){
                    if('1'==app.turnos[i].iddia){
                        //console.log('lunes');
                        app.check1E=app.turnos[i].activo;
                        app.turnoOpE1=app.turnos[i].idturnos;
                        app.idConfig1=app.turnos[i].idconfig;
                    }
                    if('2'==app.turnos[i].iddia){
                        //console.log('lunes');
                        app.check2E=app.turnos[i].activo;
                        app.turnoOpE2=app.turnos[i].idturnos;
                        app.idConfig2=app.turnos[i].idconfig;
                    }
                    if('3'==app.turnos[i].iddia){
                        //console.log('lunes');
                        app.check3E=app.turnos[i].activo;
                        app.turnoOpE3=app.turnos[i].idturnos;
                        app.idConfig3=app.turnos[i].idconfig;
                    }
                    if('4'==app.turnos[i].iddia){
                        //console.log('lunes');
                        app.check4E=app.turnos[i].activo;
                        app.turnoOpE4=app.turnos[i].idturnos;
                        app.idConfig4=app.turnos[i].idconfig;
                    }
                    if('5'==app.turnos[i].iddia){
                        //console.log('lunes');
                        app.check5E=app.turnos[i].activo;
                        app.turnoOpE5=app.turnos[i].idturnos;
                        app.idConfig5=app.turnos[i].idconfig;
                    }
                    if('6'==app.turnos[i].iddia){
                        //console.log('lunes');
                        app.check6E=app.turnos[i].activo;
                        app.turnoOpE6=app.turnos[i].idturnos;
                        app.idConfig6=app.turnos[i].idconfig;
                    }
                    if('7'==app.turnos[i].iddia){
                        //console.log('lunes');
                        app.check7E=app.turnos[i].activo;
                        app.turnoOpE7=app.turnos[i].idturnos;
                        app.idConfig7=app.turnos[i].idconfig;
                    }
                }
            });


            this.fillseccions.id=seccion.idSec;
            this.fillseccions.nombre=seccion.seccion;
            this.fillseccions.cantalumnos=seccion.cantalumnos;
            this.fillseccions.activo=seccion.activo;


            $("#boxTituloGES2").text('Grado: '+seccion.grado);
            $("#boxTituloES2").text('Sección: '+seccion.seccion);

            $("#modalEditSeccion2").modal('show');

            this.$nextTick(function () {
           $("#cbuTurno1E").focus();
          })

        },


        updateSeccion2:function (id) {
            var url="seccion/EditTurnos";

            $("#btnSaveESec2").attr('disabled', true);
            $("#btnCancelESec2").attr('disabled', true);
            this.divloaderEditSeccion2=true;


            var data = new  FormData();

            data.append('id', this.fillseccions.id);

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
                this.getGradoSeccions(this.thispage2,this.idCole);
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



    }
});


</script>