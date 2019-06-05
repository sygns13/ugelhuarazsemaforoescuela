<script type="text/javascript">
         let app = new Vue({
    el: '#app',
    data:{
        tipouserPerfil:'<?php echo e($tipouser->nombre); ?>',
        userPerfil:'<?php echo e(Auth::user()->name); ?>',
        mailPerfil:'<?php echo e(Auth::user()->email); ?>',
        imgPerfil:'<?php echo e($imagenPerfil); ?>',
        noPerfil:'noPerfil.png',

        titulo:"Datos de la UGEL Huaraz",
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
        classTitle:'fa fa-building-o',
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

        divhome:false,
        divprincipal:true,

        departamento: [],
        provincia: [],
        distrito: [],

        institucion: [],
        institucionOld: [],

        errors:[],

        fillInstitucion:{'id':'', 'nombre':'', 'direccion':'', 'telefono':'', 'correo':'', 'tipo':'', 'distrito_id':''},
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
        divNuevaArea:false,
        newArea:'',
        estadoArea:'1',

        divloaderNuevo:false,
        divloaderEdit:false,

        thispage:'1',



    },
    created:function () {
        this.getUgel();
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
        getUgel: function () {
            var busca=this.buscar;
            var urlUgel = 'ugel';

            axios.get(urlUgel).then(response=>{
                this.departamento= response.data.departamento;
                this.provincia= response.data.provincia;
                this.distrito= response.data.distritos;
                this.institucion= response.data.institucion;
                this.$nextTick(function () {
        this.fillInstitucion.id=this.institucion.id;
        this.fillInstitucion.nombre=this.institucion.nombre;
        this.fillInstitucion.direccion=this.institucion.direccion;
        this.fillInstitucion.telefono=this.institucion.telefono;
        this.fillInstitucion.correo=this.institucion.correo;
        this.fillInstitucion.distrito_id=this.institucion.distrito_id;
          })    


            })
        },

        cancelFormUgel: function () {
            
        this.institucion.id=this.fillInstitucion.id;
        this.institucion.nombre=this.fillInstitucion.nombre;
        this.institucion.direccion=this.fillInstitucion.direccion;
        this.institucion.telefono=this.fillInstitucion.telefono;
        this.institucion.correo=this.fillInstitucion.correo;
        this.institucion.distrito_id=this.fillInstitucion.distrito_id;

            $('#txtugel').focus();
        },

        updateUgel:function (id) {
            var url="ugel/"+id;
            $("#btnGuardar").attr('disabled', true);
            $("#btnCancel").attr('disabled', true);
            this.divloaderNuevo=true;

            axios.put(url, this.institucion).then(response=>{

                $("#btnGuardar").removeAttr("disabled");
                $("#btnCancel").removeAttr("disabled");
                this.divloaderNuevo=false;
                
                if(response.data.result=='1'){   
                this.getUgel(this.thispage);

                this.errors=[];
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