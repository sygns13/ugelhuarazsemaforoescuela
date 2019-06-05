<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Test Completado</h3>
              <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
            </div>

              <div class="box-body">
                	<template v-for="metodologiaD, key in metodologiaData">
<div class="callout callout-info">
             <center>   <h4>@{{metodologiaD.nombre}}</h4></center>

</div>

 <div class="col-md-12">

<h4 style="padding-top: 20px;">Resultados del Test</h4>

</div>


<div class="box-footer" style="padding-top: 20px;">

<div class="col-md-12">


<div class="form-group">

<button type="button" class="btn btn-warning" id="btnImpRes" @click.prevent="imprimirResults()"><i class="fa fa-print" aria-hidden="true" ></i> Imprimir Resultados</button>

</div>

</div>
</div>

</template>
              </div>

</div>
