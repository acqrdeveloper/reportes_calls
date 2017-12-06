@extends('layout.report')
@include('layout.plugins.css-datepicker')
@include('layout.plugins.css-dateTables')
@include('layout.plugins.js-dateTables')
@include('layout.plugins.js-datepicker')
@include('layout.plugins.css-selectboostrap')
@include('layout.plugins.js-selectbootstrap')

@section('titleReport',$titleReport)
@section('routeReport')
		@include($routeReport)
@endsection
