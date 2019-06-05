@extends('adminlte::layouts.app')

@section('htmlheader_title')
	IPP - Test Inventario de Intereses y preferencias profesionales
@endsection

<style type="text/css">         
          
#modaltamanio{
  width: 70% !important;
}

</style>
@section('main-content')
	<div class="container-fluid spark-screen">



		<div class="row">

@include('adminlte::layouts.partials.loaders')



<template v-if="divTestIPP" id="divTestIPP">
	@include('testippr.test')
</template>

<template v-if="divPreguntas" id="divPreguntas">
	@include('testippr.preguntas')
</template>

<template v-if="divResultado" id="divResultado">
	@include('testippr.resultado')
</template>



		</div>
	</div>
@endsection
