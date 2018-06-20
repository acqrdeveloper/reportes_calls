@include('layout.plugins.css-datepicker')
@include('layout.plugins.css-dateTables')
@include('layout.plugins.js-datepicker')
@include('layout.plugins.js-dateTables')

{!! Form::open([ 'method' => '', 'name'=>'buscador']) !!}
<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><b>Reportes de Estado por Agente</b></h3>
		</div>

		@include('filtros.filtro-fecha')
		@include('filtros.button-search')
</div>
{!! Form::close() !!}

@include('elements.events_consolidated.events_consolidated')
