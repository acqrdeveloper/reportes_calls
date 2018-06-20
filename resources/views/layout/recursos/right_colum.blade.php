<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Create the tabs -->
  <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
    <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
    <li><a href="#control-sidebar-theme-demo-options-tab" data-toggle="tab"><i class="fa fa-wrench"></i></a></li>
    <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">
    <!--Updated by Jasvir 01/09/2017-->
    <!-- Home tab content -->
    <div class="tab-pane active" id="control-sidebar-home-tab">
      <h3 class="control-sidebar-heading">Descripción de Estados</h3>
      <ul class="control-sidebar-menu">
        <!--estado acd-->
        <li>
          <a href="javascript:void(0)">
            <i class="menu-icon fa fa-phone bg-green"></i>
            <div class="menu-info">
              <h4 class="control-sidebar-subheading">Estado <b>ACD</b></h4>
              <p align='justify'>Estado en el cual un agente está disponible para recibir una llamada.</p>
            </div>
          </a>
        </li>
        <!--fin estado acd-->
        <!--estado break-->
        <li>
          <a href="javascript:void(0)">
            <i class="menu-icon fa fa-star bg-aqua"></i>
            <div class="menu-info">
              <h4 class="control-sidebar-subheading">Estado <b>Break</b></h4>
              <p align='justify'>Tiempo que ha utilizado el operador, con autorización del Supervisor, para ir a los servicios o atender un tema personal.</p>
            </div>
          </a>
        </li>
        <!--fin estado break-->
        <!--estado sshh-->
        <li>
          <a href="javascript:void(0)">
            <i class="menu-icon fa fa-asterisk bg-purple"></i>
            <div class="menu-info">
              <h4 class="control-sidebar-subheading">Estado <b>SS.HH</b></h4>
              <p align='justify'>Mide el tiempo que tarda un agente en los servicios higiénicos.</p>
            </div>
          </a>
        </li>
        <!--fin estado sshh-->
        <!--estado refrigerio-->
        <li>
          <a href="javascript:void(0)">
            <i class="menu-icon fa fa-cutlery bg-orange"></i>
            <div class="menu-info">
              <h4 class="control-sidebar-subheading">Estado <b>Refrigerio</b></h4>
              <p align='justify'>Mide el tiempo que el operador toma para el refrigerio de 01 hora dentro de su jornada laboral o turno.</p>
            </div>
          </a>
        </li>
        <!--fin estado refrigerio-->
        <!--estado Feedback-->
        <li>
          <a href="javascript:void(0)">
            <i class="menu-icon fa fa-retweet bg-red"></i>
            <div class="menu-info">
              <h4 class="control-sidebar-subheading">Estado <b>Feedback</b></h4>
              <p align='justify'>Tiempo en el cual el agente recibe instrucciones y/o tareas por parte del supervisor.</p>
            </div>
          </a>
        </li>
        <!--fin estado Feedback-->
        <!--estado Capacitación-->
        <li>
          <a href="javascript:void(0)">
            <i class="menu-icon fa fa-book bg-yellow"></i>
            <div class="menu-info">
              <h4 class="control-sidebar-subheading">Estado <b>Capacitación</b></h4>
              <p align='justify'>
                  Se contabiliza el tiempo en que el operador está en una reunión (en el local o fuera)
                  producto de una convocatoria del Supervisor, dentro del turno que le corresponde.
               </p>
            </div>
          </a>
        </li>
        <!--fin estado Capacitación-->
        <!--estado Gestión Backoffice-->
        <li>
          <a href="javascript:void(0)">
            <i class="menu-icon fa fa-suitcase bg-blue"></i>
            <div class="menu-info">
              <h4 class="control-sidebar-subheading">Estado <b>Gestión Backoffice</b></h4>
              <p align='justify'>
                  Seguimiento de casos para verificar el estatus, hacer
                  escalamiento de problemas o coordinar solución técnica con otra área.
              </p>
            </div>
          </a>
        </li>
        <!--fin estado Gestión Backoffice-->
      </ul>
      <!-- /.control-sidebar-menu -->

    </div>
    <!-- /.tab-pane -->

    <div class="tab-pane" id="control-sidebar-theme-demo-options-tab">
      <div>
        <h4 class="control-sidebar-heading">Layout Options</h4>
        <div class="form-group">
          <label class="control-sidebar-subheading"><input class="pull-right" data-layout="fixed" type="checkbox"> Fijar Menú de Cabecera</label>
          <p>Al momento de usar el scroll bar no se pierde el menú de cabecera</p>
        </div>
        <div class="form-group">
          <label class="control-sidebar-subheading"><input class="pull-right" data-layout="layout-boxed" type="checkbox"> Diseño en caja</label>
          <p>Activa el diseño en caja, es decir comprime el marco del front con respecto a la pantalla del usuario</p>
        </div>
        <div class="form-group">
          <label class="control-sidebar-subheading"><input class="pull-right" data-layout="sidebar-collapse" type="checkbox"> Alternar barra lateral</label>
          <p>Alterna el estado de la barra lateral izquierda (abrir o contraer)</p>
        </div>
        <h4 class="control-sidebar-heading">Skins</h4>
        <ul class="list-unstyled clearfix">
          <li style="float:left; width: 33.33333%; padding: 5px;">
            <a class="clearfix full-opacity-hover" data-skin="skin-blue" href="javascript:void(0)" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)">
              <div>
                <span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9"></span><span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span>
              </div>
              <div>
                <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
              </div></a>
            <p class="text-center no-margin">Blue</p>
          </li>
          <li style="float:left; width: 33.33333%; padding: 5px;">
            <a class="clearfix full-opacity-hover" data-skin="skin-black" href="javascript:void(0)" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)">
              <div class="clearfix" style="box-shadow: 0 0 2px rgba(0,0,0,0.1)">
                <span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe"></span><span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe"></span>
              </div>
              <div>
                <span style="display:block; width: 20%; float: left; height: 20px; background: #222"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
              </div></a>
            <p class="text-center no-margin">Black</p>
          </li>
          <li style="float:left; width: 33.33333%; padding: 5px;">
            <a class="clearfix full-opacity-hover" data-skin="skin-purple" href="javascript:void(0)" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)">
              <div>
                <span class="bg-purple-active" style="display:block; width: 20%; float: left; height: 7px;"></span><span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span>
              </div>
              <div>
                <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
              </div></a>
            <p class="text-center no-margin">Purple</p>
          </li>
          <li style="float:left; width: 33.33333%; padding: 5px;">
            <a class="clearfix full-opacity-hover" data-skin="skin-green" href="javascript:void(0)" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)">
              <div>
                <span class="bg-green-active" style="display:block; width: 20%; float: left; height: 7px;"></span><span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span>
              </div>
              <div>
                <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
              </div></a>
            <p class="text-center no-margin">Green</p>
          </li>
          <li style="float:left; width: 33.33333%; padding: 5px;">
            <a class="clearfix full-opacity-hover" data-skin="skin-red" href="javascript:void(0)" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)">
              <div>
                <span class="bg-red-active" style="display:block; width: 20%; float: left; height: 7px;"></span><span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span>
              </div>
              <div>
                <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
              </div></a>
            <p class="text-center no-margin">Red</p>
          </li>
          <li style="float:left; width: 33.33333%; padding: 5px;">
            <a class="clearfix full-opacity-hover" data-skin="skin-yellow" href="javascript:void(0)" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)">
              <div>
                <span class="bg-yellow-active" style="display:block; width: 20%; float: left; height: 7px;"></span><span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span>
              </div>
              <div>
                <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
              </div></a>
            <p class="text-center no-margin">Yellow</p>
          </li>
          <li style="float:left; width: 33.33333%; padding: 5px;">
            <a class="clearfix full-opacity-hover" data-skin="skin-blue-light" href="javascript:void(0)" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)">
              <div>
                <span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9"></span><span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span>
              </div>
              <div>
                <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
              </div></a>
            <p class="text-center no-margin" style="font-size: 12px">Blue Light</p>
          </li>
          <li style="float:left; width: 33.33333%; padding: 5px;">
            <a class="clearfix full-opacity-hover" data-skin="skin-black-light" href="javascript:void(0)" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)">
              <div class="clearfix" style="box-shadow: 0 0 2px rgba(0,0,0,0.1)">
                <span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe"></span><span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe"></span>
              </div>
              <div>
                <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
              </div></a>
            <p class="text-center no-margin" style="font-size: 12px">Black Light</p>
          </li>
          <li style="float:left; width: 33.33333%; padding: 5px;">
            <a class="clearfix full-opacity-hover" data-skin="skin-purple-light" href="javascript:void(0)" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)">
              <div>
                <span class="bg-purple-active" style="display:block; width: 20%; float: left; height: 7px;"></span><span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span>
              </div>
              <div>
                <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
              </div></a>
            <p class="text-center no-margin" style="font-size: 12px">Purple Light</p>
          </li>
          <li style="float:left; width: 33.33333%; padding: 5px;">
            <a class="clearfix full-opacity-hover" data-skin="skin-green-light" href="javascript:void(0)" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)">
              <div>
                <span class="bg-green-active" style="display:block; width: 20%; float: left; height: 7px;"></span><span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span>
              </div>
              <div>
                <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
              </div></a>
            <p class="text-center no-margin" style="font-size: 12px">Green Light</p>
          </li>
          <li style="float:left; width: 33.33333%; padding: 5px;">
            <a class="clearfix full-opacity-hover" data-skin="skin-red-light" href="javascript:void(0)" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)">
              <div>
                <span class="bg-red-active" style="display:block; width: 20%; float: left; height: 7px;"></span><span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span>
              </div>
              <div>
                <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
              </div></a>
            <p class="text-center no-margin" style="font-size: 12px">Red Light</p>
          </li>
          <li style="float:left; width: 33.33333%; padding: 5px;">
            <a class="clearfix full-opacity-hover" data-skin="skin-yellow-light" href="javascript:void(0)" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)">
              <div>
                <span class="bg-yellow-active" style="display:block; width: 20%; float: left; height: 7px;"></span><span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span>
              </div>
              <div>
                <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
              </div></a>
            <p class="text-center no-margin" style="font-size: 12px">Yellow Light</p>
          </li>
        </ul>
      </div>
    </div>

    <!-- Settings tab content -->
    <div class="tab-pane" id="control-sidebar-settings-tab">
      <form method="post">
        <h3 class="control-sidebar-heading">General Settings</h3>
        <div class="form-group">
          <label class="control-sidebar-subheading">
            It´s on develop
          </label>
        </div>
      </form>
    </div>
  </div>
</aside>