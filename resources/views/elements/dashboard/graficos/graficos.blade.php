
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <section class="connectedSortable ui-sortable">
            <div>
              <div class="box-header ui-sortable-handle" style="cursor: move;">
                <div class="small-box bg-aqua">
                        <div class="inner">
                          <h3>150</h3>
                          <p>New Orders</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-bag"></i>
                        </div>
                          <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
          </div>
          <section>
        </div>
        <div class="col-lg-3 col-xs-6">
          <section class="connectedSortable ui-sortable">
            <div>
              <div class="box-header ui-sortable-handle" style="cursor: move;">
                <div class="small-box bg-green">
                  <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3> <p>Bounce Rate</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
          </div>
          <section>
        </div>
        <div class="col-lg-3 col-xs-6">
            <section class="connectedSortable ui-sortable">
              <div>
                <div class="box-header ui-sortable-handle" style="cursor: move;">
                  <div class="small-box bg-yellow">
                    <div class="inner">
                      <h3>44</h3>   <p>User Registrations</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
            </div>
            <section>
        </div>
        <div class="col-lg-3 col-xs-6">
            <section class="connectedSortable ui-sortable">
              <div>
                <div class="box-header ui-sortable-handle" style="cursor: move;">
                  <div class="small-box bg-red">
                    <div class="inner">
                      <h3>65</h3>

                      <p>Unique Visitors</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
            </div>
            <section>
        </div>
      </div>
      <!-- /.row -->

        <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <!--inicio drop and drag 1-->

        <section class="col-lg-9 connectedSortable ui-sortable">
           <div class="box box-danger">
              <div class="box-header with-border"> <h3 class="box-title">Llamadas Abandonadas por Día</h3> </div>
              <div class="box-body">
                  <div id="llamadas_abandonadas" class="responsive">
                      <style>
                        #llamadas_abandonadas {
                          min-width: 310px;
                          max-width: 800px;
                          height: 400px;
                          margin: 0 auto
                        }
                      </style>

                  </div>
              </div>
            </div>
        </section>

        <section class="col-lg-3 connectedSortable ui-sortable">

          <div class="col-md-9">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Activity</a></li>
                  <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Timeline</a></li>
                  <li class=""><a href="#settings" data-toggle="tab" aria-expanded="false">Settings</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="activity">
                    <!-- Post -->
                    <div class="post">
                      Tab 1
                    </div>
                    <!-- /.post -->
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    <!-- The timeline -->
                    Tab 2
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="settings">
                    tab 3
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div>
              <!-- /.nav-tabs-custom -->
          </div>

        </section>

        <!--fin drop and drag 1-->
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>

<script src="{{ asset('js/drop-drag.min.js')}}"></script>
<script src="{{ asset('js/highchart.min.js')}}"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);

    Highcharts.chart('llamadas_abandonadas', {

    title: {
              text: 'LLamadas Abandonadas'
          },

    subtitle: {
              text: 'Por Día'
          },

    yAxis: {
        title: {
            text: 'Horas'
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    plotOptions: {
        series: {
            pointStart: 1
        }
    },

    series: [{
        name: 'Día',
        data: [1,2,3,4,5,6,7,8,9,10]
    }],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

  });


</script>
