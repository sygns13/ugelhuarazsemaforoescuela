<script type="text/javascript">
         let app = new Vue({
    el: '#app',
    data:{
        tipouserPerfil:'<?php echo e($tipouser->nombre); ?>',
        userPerfil:'<?php echo e(Auth::user()->name); ?>',
        mailPerfil:'<?php echo e(Auth::user()->email); ?>',
        imgPerfil:'<?php echo e($imagenPerfil); ?>',
        noPerfil:'noPerfil.png',
        titulo:"Días Feriados",
        subtitulo:"Registro",
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
        classTitle:'fa fa-calendar-times-o',
        classMenu0:'',
        classMenu1:'',
        classMenu2:'',
        classMenu3:'',
        classMenu4:'',
        classMenu5:'',
        classMenu6:'',
        classMenu7:'',
        classMenu8:'',
        classMenu9:'',
        classMenu10:'active',

        divhome:false,
        divprincipal:true,

        feriados: [],
        errors:[],
        fillArea:{'id':'', 'nombre':'', 'fecha':'','year':'','activo':''},
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
        newFeriado:'',
        newFecha:'',

        divloaderNuevo:false,
        divloaderEdit:false,

        thispage:'1',



    },
    created:function () {
        this.getFeriados(this.thispage);
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
        getFeriados: function (page) {
            var busca=this.buscar;
            var urlAreas = 'feriado?page='+page+'&busca='+busca;

            axios.get(urlAreas).then(response=>{
                this.feriados= response.data.feriados.data;
                this.pagination= response.data.pagination;

                if(this.feriados.length==0 && this.thispage!='1'){
                    var a = parseInt(this.thispage) ;
                    a--;
                    this.thispage=a.toString();
                    this.changePage(this.thispage);
                }
            })
        },
        changePage:function (page) {
            this.pagination.current_page=page;
            this.getFeriados(page);
            this.thispage=page;
        },
        buscarBtn: function () {
            this.getFeriados();
            this.thispage='1';
        },
        nuevaArea:function () {
            this.divNuevaArea=true;
            //$("#txtarea").focus();
            //$('#txtarea').focus();
            this.$nextTick(function () {
            this.cancelFormArea();
          })
            
        },
        cerrarFormArea: function () {
            this.divNuevaArea=false;
            this.cancelFormArea();
        },
        cancelFormArea: function () {
            $('#txtnombre').focus();
            this.newFeriado='';
            this.newFecha='';
        },
        createArea:function () {
            var url='feriado';
            $("#btnGuardar").attr('disabled', true);
            $("#btnCancel").attr('disabled', true);
            $("#btnClose").attr('disabled', true);
            this.divloaderNuevo=true;
            axios.post(url,{newFeriado:this.newFeriado, newFecha:this.newFecha }).then(response=>{
                //console.log(response.data);

                $("#btnGuardar").removeAttr("disabled");
                $("#btnCancel").removeAttr("disabled");
                $("#btnClose").removeAttr("disabled");
                this.divloaderNuevo=false;

                if(response.data.result=='1'){
                    this.getFeriados(this.thispage);
                    this.errors=[];
                    this.cerrarFormArea();
                    toastr.success(response.data.msj);
                }else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
            }).catch(error=>{
                this.errors=error.response.data
            })
        },
        borrarArea:function (area) {
              swal({
                  title: '¿Estás seguro?',
                  text: "¿Desea eliminar el registro Seleccionado?",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminar'
                }).then(function () {

                            var url = 'feriado/'+area.id;
                            axios.delete(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getFeriados(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        editArea:function (feriado) {

            this.fillArea.id=feriado.id;
            this.fillArea.nombre=feriado.nombre;
            this.fillArea.fecha=feriado.fecha;
            this.fillArea.year=feriado.year;
            this.fillArea.activo=feriado.activo;
            $("#boxTitulo").text('Feriado: '+feriado.nombre);
            $("#modalEditar").modal('show');
        },
        updateArea:function (id) {
            var url="feriado/"+id;
            $("#btnSaveE").attr('disabled', true);
            $("#btnCancelE").attr('disabled', true);
            this.divloaderEdit=true;

            axios.put(url, this.fillArea).then(response=>{

                $("#btnSaveE").removeAttr("disabled");
                $("#btnCancelE").removeAttr("disabled");
                this.divloaderEdit=false;
                
                if(response.data.result=='1'){   
                this.getFeriados(this.thispage);
                this.fillArea={'id':'', 'nombre':'', 'fecha':'','year':'','activo':''};
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
        bajaArea:function (area) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si se desactiva el área, se mantendrán ocultas todas las carreras profesionales pertenecientes a él, hasta que se active el área. ",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, desactivar'
                }).then(function () {

                            var url = 'feriados/altabaja/'+area.id+'/0';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getFeriados(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        altaArea:function (area) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si activa el área, todas las carreras profesionales pertenecientes al área serán visibles.",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, Activar'
                }).then(function () {

                            var url = 'feriados/altabaja/'+area.id+'/1';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getFeriados(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },

         pasfechaVista:function(date) 
        {
    date=date.slice(-2)+'/'+date.slice(-5,-3)+'/'+date.slice(0,4);

    return date;
        },
    }
});
</script>