<script type="text/javascript">
         let app = new Vue({
    el: '#app',
    data:{
        tipouserPerfil:'<?php echo e($tipouser->nombre); ?>',
        userPerfil:'<?php echo e(Auth::user()->name); ?>',
        mailPerfil:'<?php echo e(Auth::user()->email); ?>',
        imgPerfil:'<?php echo e($imagenPerfil); ?>',
        noPerfil:'noPerfil.png',
        titulo:"Reporte de Asistencia Personal",
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
        classMenu7:'active',
        classMenu8:'',
        classMenu9:'',
        classMenu10:'',
        classMenu11:'',

        divhome:false,
        divprincipal:true,

        reporte: [],
        errors:[],
        divloaderNuevo:false,
        divloaderEdit:false,

        cbufecha:0,

        fechaini:'',
        fechafin:'',
        institucions:[],
        personals:[],
        selectInsti:false,
        selectPersonal:false,

        cbuIE:0,
        nombreIE:'',
        cbuPersonal:0,




        cabehoy:'Reporte del <?php echo e($fecha); ?>',
        cabemes:'Reporte del mes de <?php echo e(nombremes($mesActual)); ?> de <?php echo e($yearActual); ?>',
        cabeyear:'Reporte del año <?php echo e($yearActual); ?>',
        cabesiempre:'Acumulado Histórico',
        caberango:'Desde: ',

        reporte2:[],
        reporte3:[],
        reporte4:[],

        trabajador:'',
        cargo:'',
        t1:'',
        t2:'',
        t3:'',
        nivel:'',



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
            var url = 'repPersonal?page='+busca+'&busca='+busca;

            axios.get(url).then(response=>{
               // this.reporte= response.data.reporte.data;
               // this.pagination= response.data.pagination;
               this.institucions= response.data.institucions;


            })
        },

        getDatos2: function () {
            this.cbuIE=$("#cbuIE").val();
            this.nombreIE=$("#cbuIE option:selected").text();

            this.cbuPersonal=0;
            this.trabajador='';
            this.cargo='';



            if(parseInt(this.cbuIE)>0){

          var url = 'repPersonal/getPersonal/'+this.cbuIE;

            axios.get(url).then(response=>{

               this.personals= response.data.personals;
               this.nivel=response.data.nivel;

               this.selectInsti=true;
               this.$nextTick(function () {
                $('#cbuPersonal').select2();
                $('#cbuPersonal').on('select2:select', function (e) {
                        app.getDatos3();
                    });

                $('#cbuPersonal').val('0').trigger('change');
                this.trabajador='';
                this.cargo='';

                })
            })
                
            }
            else{   
                this.selectInsti=false;
                this.selectSeccion=false;
                this.personals=[];
            }
            
        },

        getDatos3: function () { 

            this.cbuPersonal=$("#cbuPersonal").val();
            this.trabajador=$("#cbuPersonal option:selected").text();
            this.cargo=$("#txtcargo"+app.cbuPersonal).val();
         },



        buscarInfo:function () {

            if(this.cbuIE==-1){
                this.buscar4();
            }
            else{
                if(this.cbuIE==0){
                this.buscar1();
              }else{

                if(this.cbuPersonal==0)
                {
                    this.buscar2();
                }
                else{
                    this.buscar3();
                }
                
              }
            }
              
        },

        buscar1(){
            var url='repPersonal/buscar';


            this.divloaderNuevo=true;



            var data = new  FormData();

            data.append('idInsti', this.cbuIE);
            data.append('idPersonal', this.cbuPersonal);

            data.append('tipofecha', this.cbufecha);
            data.append('fechaini', this.fechaini);
            data.append('fechafin', this.fechafin);

            //const config = { headers: { 'Content-Type': 'multipart/form-data' } };


            axios.post(url,data).then(response=>{


                this.divloaderNuevo=false;

                if(response.data.result=='1'){

                    this.reporte= response.data.reporte;
                    //this.institucions= response.data.institucion;
                    toastr.success(response.data.msj);
                }else{
                    toastr.error(response.data.msj);
                }
            }).catch(error=>{
                this.errors=error.response.data
            })
        },

        buscar2(){
            var url='repPersonal/buscar2';


            this.divloaderNuevo=true;



            var data = new  FormData();

            data.append('idInsti', this.cbuIE);
            data.append('idPersonal', this.cbuPersonal);

            data.append('tipofecha', this.cbufecha);
            data.append('fechaini', this.fechaini);
            data.append('fechafin', this.fechafin);

            //const config = { headers: { 'Content-Type': 'multipart/form-data' } };


            axios.post(url,data).then(response=>{


                this.divloaderNuevo=false;

                if(response.data.result=='1'){

                    this.reporte2= response.data.reporte2;
                    //this.institucions= response.data.institucion;
                    toastr.success(response.data.msj);
                }else{
                    toastr.error(response.data.msj);
                }
            }).catch(error=>{
                this.errors=error.response.data
            })
        },

        buscar4(){
            var url='repPersonal/buscar4';


            this.divloaderNuevo=true;



            var data = new  FormData();

            data.append('idInsti', this.cbuIE);
            data.append('idPersonal', this.cbuPersonal);

            data.append('tipofecha', this.cbufecha);
            data.append('fechaini', this.fechaini);
            data.append('fechafin', this.fechafin);

            //const config = { headers: { 'Content-Type': 'multipart/form-data' } };


            axios.post(url,data).then(response=>{


                this.divloaderNuevo=false;

                if(response.data.result=='1'){

                    this.reporte4= response.data.reporte4;
                    //this.institucions= response.data.institucion;
                    toastr.success(response.data.msj);
                }else{
                    toastr.error(response.data.msj);
                }
            }).catch(error=>{
                this.errors=error.response.data
            })
        },

        buscar3(){
            var url='repPersonal/buscar3';


            this.divloaderNuevo=true;



            var data = new  FormData();

            data.append('idInsti', this.cbuIE);
            data.append('idPersonal', this.cbuPersonal);

            data.append('tipofecha', this.cbufecha);
            data.append('fechaini', this.fechaini);
            data.append('fechafin', this.fechafin);

            //const config = { headers: { 'Content-Type': 'multipart/form-data' } };


            axios.post(url,data).then(response=>{


                this.divloaderNuevo=false;

                if(response.data.result=='1'){

                    this.reporte3= response.data.reporte3;
                    this.t1=response.data.t1;
                    this.t2=response.data.t2;
                    this.t3=response.data.t3;
                    //this.institucions= response.data.institucion;
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