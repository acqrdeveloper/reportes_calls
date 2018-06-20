@extends('layout.frontPanel')
@section('title', getenv('PROYECT_NAME_COMPLETE'))
@section('content')
	@include('layout.recursos.modals.modal_loading')
		<div id="container"> </div>
@endsection
