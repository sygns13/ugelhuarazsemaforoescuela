@extends('adminlte::layouts.app')

@section('htmlheader_title')
	Reportes de Asistencia de Personal
@endsection

<style type="text/css">         
          
#modaltamanio{
  width: 70% !important;
}

@media print {
body {-webkit-print-color-adjust: exact;}
}

</style>
@section('main-content')
	<div class="container-fluid spark-screen">



		<div class="row">

@include('adminlte::layouts.partials.loaders')

			@if(accesoUser([1,2,3]))

<template v-if="divprincipal" id="divprincipal">
	@include('reportePersonal.principal')
</template>
			@endif


		</div>
	</div>
@endsection
