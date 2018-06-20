@extends('layout.dashboard')
@section('title', 'Dashboard')
@section('css')
  {!!Html::style('css/dashboard.css')!!}
@stop
@section('content')
    <p></p>
    <audio ref="audioElm" :src="routeMusicQueue" preload="none" loop></audio>
    <div>
        @include('elements.dashboard.pictures_kpi.index')
        @include('elements.dashboard.tables.calls_inbound')
        <div class="row">
            <div class="col-md-8">
                @include('elements.dashboard.tables.calls_waiting')
                @include('elements.dashboard.tables.calls_outbound')
                @include('elements.dashboard.tables.other_agents')
            </div>
            <div class="col-md-4">
                <div class="col-md-12">
                    @include('elements.dashboard.panels_kpi.filterdashboard')
                </div>
                <div class="col-md-12">
                    @include('elements.dashboard.panels_kpi.agentactivitysummary')
                </div>
                <div class="col-md-12">
                    @include('elements.dashboard.panels_kpi.groupstatistics')
                </div>
            </div>
        </div>
    <!--<pre>@{{ $data }}</pre>-->
    </div>
@endsection

@section('scripts')
    {!!Html::script('js/dashboard_vue.min.js?version='.date('YmdHis'))!!}
@endsection
