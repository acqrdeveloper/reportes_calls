<div class="col-md-2 col-sm-4 col-xs-8" @click="loadMetricasKpi">
  <div class="info-box bg-aqua" v-if="answered != '-'">
    <span class="info-box-icon metricas-info-box-icon"><i class="fa fa-clock-o"></i></span>
    <div class="info-box-content metricas-info-box-content" >
    	<span class="info-box-text metricas-info-box-text">Talk Time</span>
    	<span class="info-box-number metricas-info-box-number">@{{ TiempoHablado }}</span>
    </div>
  </div>
  <div v-else="answered = '-'">@include('layout.recursos.loading_bar')</div>
</div>
