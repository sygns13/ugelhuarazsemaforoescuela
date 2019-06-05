<script type="text/javascript">
         let app = new Vue({
    el: '#app',
    data:{
        tipouserPerfil:'<?php echo e($tipouser->nombre); ?>',
        userPerfil:'<?php echo e(Auth::user()->name); ?>',
        mailPerfil:'<?php echo e(Auth::user()->email); ?>',
        imgPerfil:'<?php echo e($imagenPerfil); ?>',
        noPerfil:'noPerfil.png',

        titulo:"Registro de Asistencia",
        subtitulo:"Alumnos de Instituciones Educativas",
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
        classTitle:'fa fa-calendar-check-o',
        classMenu0:'',
        classMenu1:'active',
        classMenu2:'',
        classMenu3:'',
        classMenu4:'',
        classMenu5:'',
        classMenu6:'',
        classMenu7:'',
        classMenu8:'',
        classMenu9:'',
        classMenu10:'',
        classMenu11:'',

        divPrincipal:true,

        institucion: [],
        datosColegio: [],
        numAlumnos:[],
        numTurnos:[],
        nivel: [],
        tipogestion: [],
        tipoie: [],

        grados: [],
        secciones:[],


        fillInstitucion:{'id':''},

        errors:[],
        fillCamposProfs:{'id':'', 'nombre':'', 'orden':'','activo':'1','metodologiavocacional_id':''},
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
        divloaderEdit:false,

        <?php 
        $bandera=false;
         ?>
        <?php $__currentLoopData = $turnoActivo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dato): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        keyturno:'<?php echo e($dato->id); ?>',
        turno:'<?php echo e($dato->descripcion); ?>',
        horaini:'<?php echo e($dato->horaIni); ?>',
        horafin:'<?php echo e($dato->horaFin); ?>',
        <?php 
        $bandera=true;
         ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if($bandera==false): ?>
         keyturno:'',
        turno:'No hay un turno activo en este momento',
        horaini:'',
        horafin:'',
        <?php endif; ?>
        

        fecha:'<?php echo e($fecha); ?>',
        hora:'<?php echo e($hora); ?>',

        yA:<?php echo e($yearActual); ?>,
        mA:<?php echo e($mesActual); ?>,
        dA:<?php echo e($diaActual); ?>,
        hA:<?php echo e($horaActual); ?>,
        mA:<?php echo e($minActual); ?>,
        sA:<?php echo e($secActual); ?>,

        horaSis: new Date(<?php echo e($yearActual); ?>, <?php echo e($mesActual); ?>, <?php echo e($diaActual); ?>, <?php echo e($horaActual); ?>, <?php echo e($minActual); ?>, <?php echo e($secActual); ?>),

        thispage:'1',

        turns:[],



    },
    created:function () {

        this.getMainAsistenciaAlumnos(this.thispage);
    },
    mounted: function () {
        this.divloader0=false;

        if(this.imgPerfil.length>0){
            $(".imgPerfil").attr("src","<?php echo e(asset('/img/perfil/')); ?>"+"/"+this.imgPerfil);
        }
        else{
            $(".imgPerfil").attr("src","<?php echo e(asset('/img/perfil/')); ?>"+"/"+this.noPerfil);
        }
        setInterval(this.obtenerHora, 1000);
 
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
        Asistencia:function(institucion){
            //alert(idinsti);


            var url = 'AsistenciaAlumnos/abrirIE/'+institucion.idcolegio+'/0';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                toastr.success(response.data.msj);
                                app.grados=response.data.grados;
                                app.secciones=response.data.secciones;
                $("#boxTitulo").text('Institución educativa: '+institucion.nombre+' Código Modular: '+institucion.codigomod);
                $("#modalAsistencia").modal('show');
                this.$nextTick(function () {
                    $(".txtAs:first").focus();
                  })
                                
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
        },
        obtenerHora:function () {
            
            var secs=this.horaSis.getSeconds();
            var mins=this.horaSis.getMinutes();
            var hours=this.horaSis.getHours();

            var dias=this.horaSis.getDate();
            var mess=this.horaSis.getMonth();
            mess++;
            var years=this.horaSis.getFullYear();

            secs=secs+1;



            this.horaSis.setSeconds(secs);


            if(secs<10){
                var secs="0"+secs;
            }
            if(mins<10){
                var mins="0"+mins;
            }
            if(hours<10){
                var hours="0"+hours;
            }

            if(dias<10){
                var dias="0"+dias;
            }
            if(mess<10){
                var mess="0"+mess;
            }


            var dame_hora = hours + ":" + mins + ":" + secs;
            var dame_fecha= dias + "/" + mess + "/" + years;
            this.hora=dame_hora;
            this.fecha=dame_fecha;

           //app.getTurnos();

            var timeC = new Date();

            timeC.setHours(dame_hora.split(":")[0],dame_hora.split(":")[1],dame_hora.split(":")[2]);



             var timeA1 = new Date();
             var timeB1 = new Date();

             var timeA2 = new Date();
             var timeB2 = new Date();

             var timeA3 = new Date();
             var timeB3 = new Date();



           var t1hini=app.turns[0].horaIni;
           var t1hfin=app.turns[0].horaFin;

           var t2hini=app.turns[1].horaIni;
           var t2hfin=app.turns[1].horaFin;

           var t3hini=app.turns[2].horaIni;
           var t3hfin=app.turns[2].horaFin;



            timeA1.setHours(t1hini.split(":")[0],t1hini.split(":")[1],t1hini.split(":")[2]);
            timeB1.setHours(t1hfin.split(":")[0],t1hfin.split(":")[1],t1hfin.split(":")[2]);

           timeA2.setHours(t2hini.split(":")[0],t2hini.split(":")[1],t2hini.split(":")[2]);
            timeB2.setHours(t2hfin.split(":")[0],t2hfin.split(":")[1],t2hfin.split(":")[2]);

           timeA3.setHours(t3hini.split(":")[0],t3hini.split(":")[1],t3hini.split(":")[2]);
            timeB3.setHours(t3hfin.split(":")[0],t3hfin.split(":")[1],t3hfin.split(":")[2]);

            //console.log(timeA1+' - '+timeC);

            if(timeA1<timeC){
               // console.log('Si01');
            }

            if(timeB1<timeC){
               // console.log('Si02');
            }

            if(app.keyturno!=''){
               // console.log('Si03');
            }

            if(timeA2<timeC){
                //console.log('Si');
            }
            if(timeB2>timeC){
                //console.log('SiB');
            }
            if(app.keyturno==''){
                //console.log('SiC');
            }

if(timeA3<timeC && timeB3>timeC && app.keyturno==''){
                            app.getTurnos();
                         }
if(timeA2<timeC && timeB2>timeC && app.keyturno==''){
                    app.getTurnos();
                 }

if(timeA1<timeC && timeB1>timeC && app.keyturno==''){
                app.getTurnos();
             }


            if(timeA1<timeC && timeB1<timeC && app.keyturno!=''){
                //app.getTurnos();

                if(timeA2<timeC && timeB2<timeC && app.keyturno!=''){
                //app.getTurnos();

                        if(timeA3<timeC && timeB3<timeC && app.keyturno!=''){
                        app.getTurnos();
                         }

                         if(timeA3>timeC && timeB3>timeC && app.keyturno!=''){
                            app.getTurnos();
                         }

                         
                 }

                 if(timeA2>timeC && timeB2>timeC && app.keyturno!=''){
                    //app.getTurnos();
                        if(timeA3<timeC && timeB3<timeC && app.keyturno!=''){
                        app.getTurnos();
                         }

                         if(timeA3>timeC && timeB3>timeC && app.keyturno!=''){
                            app.getTurnos();
                         }

                         
                 }

                 if(timeA2<timeC && timeB2>timeC && app.keyturno==''){
                    app.getTurnos();
                 }


             }

             if(timeA1>timeC && timeB1>timeC && app.keyturno!=''){
                //app.getTurnos();


                if(timeA2<timeC && timeB2<timeC && app.keyturno!=''){
                //app.getTurnos();

                    if(timeA3<timeC && timeB3<timeC && app.keyturno!=''){
                        app.getTurnos();
                         }

                         if(timeA3>timeC && timeB3>timeC && app.keyturno!=''){
                            app.getTurnos();
                         }

                         if(timeA3<timeC && timeB3>timeC && app.keyturno==''){
                            app.getTurnos();
                         }
                 }

                 if(timeA2>timeC && timeB2>timeC && app.keyturno!=''){
                    //app.getTurnos();
                        if(timeA3<timeC && timeB3<timeC && app.keyturno!=''){
                        app.getTurnos();
                         }

                         if(timeA3>timeC && timeB3>timeC && app.keyturno!=''){
                            app.getTurnos();
                         }

                         if(timeA3<timeC && timeB3>timeC && app.keyturno==''){
                            app.getTurnos();
                         }
                 }

  
             }


        },
        getMainAsistenciaAlumnos: function (page) {
            var busca=this.buscar;
            var urlCampos ='AsistenciaAlumnos?page='+page+'&busca='+busca;

            axios.get(urlCampos).then(response=>{

        this.institucion=response.data.institucion.data;
        this.pagination= response.data.pagination;
        this.numAlumnos=response.data.numAlumnos;
        this.numTurnos=response.data.numTurnos;
        this.turns=response.data.turns;

            })
        },
        getTurnos:function () {
        
        var variable=app.keyturno;

        if(variable.length==0){
            variable="1";
        }

                            var url = 'AsistenciaAlumnos/revTurno/'+variable+'';
                            axios.get(url).then(response=>{

                    
                                //app.getMainAsistenciaAlumnos(app.thispage);//listamos
                                app.keyturno=String(response.data.keyturno);
                                app.turno=response.data.turno;
                                app.horaini=response.data.horaini;
                                app.horafin=response.data.horafin;
                                if(response.data.result=="1"){
                                    toastr.success(response.data.msj);

                                }
                                else{
                                    toastr.error(response.data.msj);
                                }
            
        
                            });
                        
                   
        },

        createAsistencias:function () {
            var b=true;
            var b1=true;
            var b2=true;
            var idSec="";
            $.each(app.secciones, function( i, sec ) {
                  //alert( index + ": " + value );
                 // console.log(app.secciones[i].cantasist)
            if(String(app.secciones[i].activoDia)=="1" && String(app.secciones[i].idturno)==String(app.keyturno)){
                if(isNaN(parseInt(app.secciones[i].cantasist))==true){
                    idSec=app.secciones[i].idSec;
                    b=false;
                }else{
                    if(parseInt(app.secciones[i].cantasist)<0){
                        idSec=app.secciones[i].idSec;
                        b1=false;
                    }
                    else{
                        if(parseInt(app.secciones[i].cantasist)>parseInt(app.secciones[i].cantalumnos)){
                        idSec=app.secciones[i].idSec;
                        b2=false;
                        }
                    }
                }

            }

                });

            if(b==true){
                    if(b1==true){
                            if(b2==true){
                                


            var url='AsistenciaAlumnos';
            $("#btnSaveE").attr('disabled', true);
            $("#btnCancelE").attr('disabled', true);
            //$("#btnClose").attr('disabled', true);
            this.divloaderEdit=true;
            axios.post(url,{secciones:this.secciones, keyturno:this.keyturno }).then(response=>{
                //console.log(response.data);

                $("#btnSaveE").removeAttr("disabled");
                $("#btnCancelE").removeAttr("disabled");
                //$("#btnClose").removeAttr("disabled");
                this.divloaderEdit=false;

                if(response.data.result=='1'){
                    this.getMainAsistenciaAlumnos(this.thispage);
                    this.errors=[];
                    $("#modalAsistencia").modal('hide');
                    toastr.success(response.data.msj);
                }else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
            }).catch(error=>{
                this.errors=error.response.data
            })



                                }
                            else{
                                toastr.error("La Cantidad de Asistentes no puede ser mayor a la cantidad de alumnos");
                                $("#txtAsist"+idSec).focus();
                                }
                    }
                else{
                    toastr.error("La Cantidad de Asistentes no puede ser menor a cero");
                    $("#txtAsist"+idSec).focus();
                    }
                }
            else{
                toastr.error("Complete adecuadamente la cantidad de Asistentes");
                $("#txtAsist"+idSec).focus();
            }


        },





















        changePage:function (page) {
            this.pagination.current_page=page;
            this.getMainAsistenciaAlumnos(page);
            this.thispage=page;
        },
        buscarBtn: function () {
            this.getMainAsistenciaAlumnos();
            this.thispage='1';
        },
        nuevoCampoProf:function () {
            this.divNuevoCampoProf=true;

            this.$nextTick(function () {
            this.cancelFormCampoProf();
          })
            
        },
        cerrarFormCampoProf: function () {
            this.divNuevoCampoProf=false;
            this.cancelFormCampoProf();
        },
        cancelFormCampoProf: function () {
            $('#txtNombre').focus();
            this.newNombre='';
            this.newOrden='';
            this.estadoCampoProf='1';
        },
        createCampoProf:function () {
            var url='campoProfesional';
            $("#btnGuardar").attr('disabled', true);
            $("#btnCancel").attr('disabled', true);
            $("#btnClose").attr('disabled', true);
            this.divloaderNuevo=true;
            axios.post(url,{nombre:this.newNombre, orden:this.newOrden, estado:this.estadoCampoProf,metodologiavocacional_id:this.metodologiavocacional_id }).then(response=>{
                //console.log(response.data);

                $("#btnGuardar").removeAttr("disabled");
                $("#btnCancel").removeAttr("disabled");
                $("#btnClose").removeAttr("disabled");
                this.divloaderNuevo=false;

                if(response.data.result=='1'){
                    this.getMainAsistenciaAlumnos(this.thispage);
                    this.errors=[];
                    this.cerrarFormCampoProf();
                    toastr.success(response.data.msj);
                }else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
            }).catch(error=>{
                this.errors=error.response.data
            })
        },
        borrarCampoProf:function (campo) {
              swal({
                  title: '¿Estás seguro?',
                  text: "¿Desea eliminar el Área de Interés Seleccionado? -- Nota: Para eliminar esta área, debe primero eliminar todas las carreras profesionales que se encuentran registradas en él y todas las alternativas que se encuentran asociadas a él.",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminar'
                }).then(function () {

                            var url = 'campoProfesional/'+campo.id;
                            axios.delete(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getMainAsistenciaAlumnos(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        editCampoProf:function (campo) {

            this.fillCamposProfs.id=campo.id;
            this.fillCamposProfs.nombre=campo.nombre;
            this.fillCamposProfs.orden=campo.orden;
            this.fillCamposProfs.activo=campo.activo;
            this.fillCamposProfs.metodologiavocacional_id=campo.metodologiavocacional_id;

            $("#boxTitulo").text('Área de Interés: '+campo.nombre);
            $("#modalEditar").modal('show');
        },
        updateCampos:function (id) {
            var url="campoProfesional/"+id;
            $("#btnSaveE").attr('disabled', true);
            $("#btnCancelE").attr('disabled', true);
            this.divloaderEdit=true;

            axios.put(url, this.fillCamposProfs).then(response=>{

                $("#btnSaveE").removeAttr("disabled");
                $("#btnCancelE").removeAttr("disabled");
                this.divloaderEdit=false;
                
                if(response.data.result=='1'){   
                this.getMainAsistenciaAlumnos(this.thispage);
                this.fillCamposProfs={'id':'', 'nombre':'', 'orden':'','activo':'1','metodologiavocacional_id':''};
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
        bajaCampoProf:function (campo) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si se desactiva el área de interés, se mantendrán ocultas todas las carreras profesionales pertenecientes a él y todas las alternativas asociadas a él, hasta que se active el área. ",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, desactivar'
                }).then(function () {

                            var url = 'campoProfesional/altabaja/'+campo.id+'/0';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getMainAsistenciaAlumnos(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        altaCampoProf:function (campo) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si activa el área de interés, todas las carreras profesionales pertenecientes al área serán visibles y todas las alternativas asociadas a él.",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, Activar'
                }).then(function () {

                            var url = 'campoProfesional/altabaja/'+campo.id+'/1';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getMainAsistenciaAlumnos(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
    }
});
</script>