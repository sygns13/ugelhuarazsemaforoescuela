@extends('adminlte::layouts.app')

@section('htmlheader_title')
	Asistencia de Personal
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

			@if(accesoUser([1,2,3]))

<template v-if="divPrincipal" id="divPrincipal">
	@include('asistenciapersonal.principal')
</template>
			@endif


		</div>
	</div>
@endsection
