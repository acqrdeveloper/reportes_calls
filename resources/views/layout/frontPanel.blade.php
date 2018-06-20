<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @include('layout.recursos.icon_title')
    <title>Reportes | @yield('title')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="_token" content="{{ csrf_token() }}">
    {!! Html::style('css/adminlte.min.css?version='.date('YmdHis')) !!}
    {!! Html::style('css/notifications.min.css?version='.date('YmdHis')) !!}
    {!! Html::style('css/fonts-googleapis.css?version='.date('YmdHis')) !!}
    @yield('css')
  </head>
  <body class=" sidebar-mini {{getenv('REPORT_THEME')}}  " style="padding-right: 0px !important;">

    <div class="wrapper" style="height: auto; min-height: 100%;" id="frontAminLTE">
      @include('layout.recursos.header.index')
      @include('layout.recursos.left_menu.index')
      <div class="content-wrapper">
        @include('layout.recursos.flash_message')
          <section class="content-header">
            <h1>Front Panel, <small>Hola @{{ getNameComplete }}</small>
            </h1>
            <ol class="breadcrumb">
              <li><i class="fa fa-fw fa-calendar"></i> @{{ textDateServer }} &nbsp; <i class="fa fa-fw fa-clock-o"></i> @{{ hourServer }}</li>
              <li><a href="/"><i class="fa fa-dashboard"></i>Inicio</a></li>
              <li class="active" id='urlsistema'></li>
            </ol>
          </section>
          <section class="content">
            @yield('content')
          </section>
      </div>
      @include('layout.recursos.footer')
      @include('layout.recursos.right_colum')
      @include('layout.recursos.modals.modal_status')
      @include('layout.recursos.modals.modal_reconnect')
      @include('layout.recursos.modals.modal_asssistance')
      @include('layout.recursos.modals.modal_standby')
      @include('layout.recursos.modals.modal_releases_annexed')
      @include('layout.recursos.modals.modal_asterisk')
      @include('layout.recursos.modals.modal_users')
      @include('layout.recursos.modals.modal_leyendas')
      <div class="control-sidebar-bg"></div>
    </div>
    {!! Html::script('js/adminlte.min.js?version='.date('YmdHis')) !!}
    {!! Html::script('js/notifications.min.js?version='.date('YmdHis')) !!}
    {!! Html::script('js/vuesockets.min.js?version='.date('YmdHis')) !!}
    {!! Html::script('js/personalizeFunctions.min.js?version='.date('YmdHis')) !!}
    {!! Html::script('js/push.min.js?version='.date('YmdHis')) !!}
    @include('layout.recursos.fecha_hora')
    @yield('scripts')
  </body>
</html>
