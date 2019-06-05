<script type="text/javascript">
         let app = new Vue({
    el: '#app',
    data:{
        tipouserPerfil:'<?php echo e($tipouser->nombre); ?>',
        userPerfil:'<?php echo e(Auth::user()->name); ?>',
        mailPerfil:'<?php echo e(Auth::user()->email); ?>',
        imgPerfil:'<?php echo e($imagenPerfil); ?>',
        noPerfil:'noPerfil.png',
        titulo:"Reporte de Asistencia Alumno",
        subtitulo:"Imprimir",
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
        classTitle:'fa fa-print',
        classMenu0:'',
        classMenu1:'',
        classMenu2:'',
        classMenu3:'',
        classMenu4:'',
        classMenu5:'',
        classMenu6:'',
        classMenu7:'',
        classMenu8:'active',
        classMenu9:'',
        classMenu10:'',
        classMenu11:'',

        divhome:false,
        divprincipal:true,

        reporte: [],
        reporte2: [],
        reporte3: [],
        errors:[],
        divloaderNuevo:false,
        divloaderEdit:false,

        cbufecha:0,

        fechaini:'',
        fechafin:'',
        institucions:[],
        grados:[],
        seccions:[],
        selectInsti:false,
        selectGrado:false,
        selectSeccion:false,
        cbuIE:0,
        nombreIE:'',
        nivel:'',
        cbuGrados:0,
        cbuSeccion:0,

        grado:'',
        seccion:'',



        cabehoy:'Reporte del <?php echo e($fecha); ?>',
        cabemes:'Reporte del mes de <?php echo e(nombremes($mesActual)); ?> de <?php echo e($yearActual); ?>',
        cabeyear:'Reporte del año <?php echo e($yearActual); ?>',
        cabesiempre:'Acumulado Histórico',
        caberango:'Desde: ',



    },
    created:function () {
        this.getDatos();
    },
    mounted: function () {
        this.divloader0=false;

        if(this.imgPerfil.length>0){
            $(".imgPerfil").attr("src","<?php echo e(asset('/img/perfil/')); ?>"+"/"+this.imgPerfil);
        }
        else{
            $(".imgPerfil").attr("src","<?php echo e(asset('/img/perfil/')); ?>"+"/"+this.noPerfil);
        }

        $('#cbuIE').select2();
        $('#cbuGrados').select2();
        $('#cbuSecciones').select2();
 
    },

    methods: {
        getDatos: function () {
            var busca=this.buscar;
            var url = 'repAlumnos?page='+busca+'&busca='+busca;

            axios.get(url).then(response=>{
               // this.reporte= response.data.reporte.data;
               // this.pagination= response.data.pagination;
               this.institucions= response.data.institucions;


            })
        },

        getDatos2: function () {
            this.cbuIE=$("#cbuIE").val();
            this.nombreIE=$("#cbuIE option:selected").text();
            this.nivel=$("#txtnivel"+app.cbuIE).val();

            if(parseInt(this.cbuIE)>0){

          var url = 'repAlumnos/getGrados/'+this.cbuIE;

            axios.get(url).then(response=>{

               this.grados= response.data.grados;
               this.selectInsti=true;
               this.$nextTick(function () {
                $('#cbuGrados').select2();

                $('#cbuGrados').on('select2:select', function (e) {
                    app.getDatos3();
                });

                $('#cbuGrados').val('0').trigger('change');
                this.grado='';
                /*
                 $('#cbuSeccion').val('0').trigger('change');
                this.seccion='';*/



                })
            })
                
            }
            else{   
                this.selectInsti=false;
                this.selectSeccion=false;
                this.grados=[];
                this.seccions=[];
            }
            
        },

        getDatos3: function () {

            this.cbuGrados=$("#cbuGrados").val();
           /* this.grado=$("#cbuGrados option:selected").text();


            if(parseInt(this.cbuGrados)>0){

          var url = 'repAlumnos/getSeccions/'+this.cbuGrados;

            axios.get(url).then(response=>{

               this.seccions= response.data.seccions;
               this.selectSeccion=true;
               this.$nextTick(function () {
                $('#cbuSecciones').select2();
                $('#cbuSecciones').on('select2:select', function (e) {
                    app.cbuSeccion=$("#cbuSecciones").val();
                    app.getDatos4();
                });

                $('#cbuSeccion').val('0').trigger('change');
                this.seccion='';
                })
            })
                
            }
            else{   
                this.selectSeccion=false;
                this.seccions=[];
            }*/
            
        },


        getDatos4: function () { 

            this.cbuSeccion=$("#cbuSecciones").val();
            this.seccion=$("#cbuSecciones option:selected").text();
         },

        buscarInfo:function () {
              if(this.cbuIE==0){
                this.buscar1();
              }else{

                if(this.cbuGrados==0)
                {
                    this.buscar2();
                }
                else{
                    this.buscar3();
                }
                
              }
        },

        buscar1:function(){
            var url='repAlumnos/buscar';


            this.divloaderNuevo=true;



            var data = new  FormData();

            data.append('idColegio', this.cbuIE);
            data.append('idGrados', this.cbuGrados);
            data.append('idSeccions', this.cbuSeccion);
            data.append('tipofecha', this.cbufecha);
            data.append('fechaini', this.fechaini);
            data.append('fechafin', this.fechafin);

            //const config = { headers: { 'Content-Type': 'multipart/form-data' } };


            axios.post(url,data).then(response=>{


                this.divloaderNuevo=false;

                if(response.data.result=='1'){

                    this.reporte= response.data.reporte;
                    toastr.success(response.data.msj);
                }else{
                    toastr.error(response.data.msj);
                }
            }).catch(error=>{
                this.errors=error.response.data
            })
        },
        buscar2:function(){
            var url='repAlumnos/buscar2';


            this.divloaderNuevo=true;



            var data = new  FormData();

            data.append('idColegio', this.cbuIE);
            data.append('idGrados', this.cbuGrados);
            data.append('idSeccions', this.cbuSeccion);
            data.append('tipofecha', this.cbufecha);
            data.append('fechaini', this.fechaini);
            data.append('fechafin', this.fechafin);

            //const config = { headers: { 'Content-Type': 'multipart/form-data' } };


            axios.post(url,data).then(response=>{


                this.divloaderNuevo=false;

                if(response.data.result=='1'){

                    this.reporte2= response.data.reporte;
                    toastr.success(response.data.msj);
                }else{
                    toastr.error(response.data.msj);
                }
            }).catch(error=>{
                this.errors=error.response.data
            })
        },

        buscar3:function(){
            var url='repAlumnos/buscar3';


            this.divloaderNuevo=true;



            var data = new  FormData();

            data.append('idColegio', this.cbuIE);
            data.append('idGrados', this.cbuGrados);
            data.append('idSeccions', this.cbuSeccion);
            data.append('tipofecha', this.cbufecha);
            data.append('fechaini', this.fechaini);
            data.append('fechafin', this.fechafin);

            //const config = { headers: { 'Content-Type': 'multipart/form-data' } };


            axios.post(url,data).then(response=>{


                this.divloaderNuevo=false;

                if(response.data.result=='1'){

                    this.reporte3= response.data.reporte;
                    toastr.success(response.data.msj);
                }else{
                    toastr.error(response.data.msj);
                }
            }).catch(error=>{
                this.errors=error.response.data
            })
        },

        buscarBtn: function () {
            this.getDatos();
        },
      
         pasfechaVista:function(date) 
        {
    date=date.slice(-2)+'/'+date.slice(-5,-3)+'/'+date.slice(0,4);

    return date;
        },
        imprimirPlantilla:function () {
            $("#divImp").printArea();
        }
    }
});

$('#cbuIE').on('select2:select', function (e) {
    app.getDatos2();
});




</script>