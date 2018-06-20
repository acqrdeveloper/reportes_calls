<section class="content">
  <div class="row">
    <!-- inicio de kpis -->
    @include('elements.dashboard03.kpis.kpi_01')
    @include('elements.dashboard03.kpis.kpi_02')
    @include('elements.dashboard03.kpis.kpi_03')
    @include('elements.dashboard03.kpis.kpi_04')
    <!-- fin de kpis -->
  </div>

  <div class="row">
      <!--graficos del lado derecho-->
    <section class="col-lg-9 connectedSortable ui-sortable">
      @include('elements.dashboard03.graphics.graphics',['graphicName' => 'abandonedCalls'])
      @include('elements.dashboard03.graphics.graphics',['graphicName' => 'averageAttention'])
      @include('elements.dashboard03.graphics.graphics',['graphicName' => 'answeredCallsQueue'])
      @include('elements.dashboard03.graphics.graphics',['graphicName' => 'attendedAbandoned'])
    </section>
      <!--graficos del lado izquierdo-->
    <section class="col-lg-3 connectedSortable ui-sortable">
      @include('elements.dashboard03.graphics.graphicsTabs')
    </section>
  </div>
</section>
{!! Html::script('js/drop-drag.min.js?version='.date('YmdHis')) !!}
{!! Html::script('js/highchart.min.js?version='.date('YmdHis')) !!}
{!! Html::script('js/graphics.js?version='.date('YmdHis')) !!}
<script>
  $.widget.bridge('uibutton', $.ui.button)
  generateLineGraph(parameter01)
  generateLineGraph(parameter02)
  generateBarGraph(parameterBar)
  generateBarVerticalGraph(parameterBarVertical)

</script>
