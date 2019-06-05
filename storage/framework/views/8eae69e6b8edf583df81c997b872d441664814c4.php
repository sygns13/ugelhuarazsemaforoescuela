<script type="text/javascript">
         let app = new Vue({
    el: '#app',
    data:{
        tipouserPerfil:'<?php echo e($tipouser->nombre); ?>',
        userPerfil:'<?php echo e(Auth::user()->name); ?>',
        mailPerfil:'<?php echo e(Auth::user()->email); ?>',
        imgPerfil:'<?php echo e($imagenPerfil); ?>',
        noPerfil:'noPerfil.png',

        titulo:"Turnos",
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
        classTitle:'fa fa-calendar',
        classMenu0:'',
        classMenu1:'',
        classMenu2:'',
        classMenu3:'active',
        classMenu4:'',
        classMenu5:'',
        classMenu6:'',
        classMenu7:'',
        classMenu8:'',
        classMenu9:'',
        classMenu10:'',

        divhome:false,
        divprincipal:true,

        

        errors:[],

        
        turnos1:[],
        turnos2:[],

        fillTurno:{'id':'','descripcion':'','codigo':'','tipo':'','horaIni':'','horaFin':''},

        divloaderEdit:false,





    },
    created:function () {
        this.getTurno();
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
        getTurno: function () {
            var busca=this.buscar;
            var urlTurno = 'turno';

            axios.get(urlTurno).then(response=>{
                app.turnos1=response.data.turnos1;
                app.turnos2=response.data.turnos2;
            })
                
        },

        editTurno:function (turno,tipo) {



            this.fillTurno.id=turno.id;
            this.fillTurno.descripcion=turno.descripcion;
            this.fillTurno.codigo=turno.codigo;
            this.fillTurno.tipo=turno.tipo;
            this.fillTurno.horaIni=turno.horaIni;
            this.fillTurno.horaFin=turno.horaFin;


            $("#boxTitulo").text('Turno: '+turno.descripcion);

            if(tipo=='1'){
                $("#boxTituloAplic").text('Aplicado al Personal (Directivo, Docentes, Otro Personal)');
            }
            if(tipo=='2'){
                $("#boxTituloAplic").text('Aplicado a Alumnos');
            }

            
            $("#modalEditar").modal('show');

            this.$nextTick(function () {
           $("#hraIni").focus();
          })
        },

        updateTurno:function (id) {
            var url="turno/"+id;
            $("#btnSaveE").attr('disabled', true);
            $("#btnCancelE").attr('disabled', true);
            this.divloaderEdit=true;

            axios.put(url, this.fillTurno).then(response=>{

                $("#btnSaveE").removeAttr("disabled");
                $("#btnCancelE").removeAttr("disabled");
                this.divloaderEdit=false;
                
                if(response.data.result=='1'){   
                this.getTurno(this.thispage);

                this.errors=[];
                toastr.success(response.data.msj);
                $("#modalEditar").modal('hide');

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