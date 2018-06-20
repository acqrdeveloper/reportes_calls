<div class="col-md-2 col-sm-6 col-xs-6" @click="loadMetricasKpi">
  <div class="info-box bg-yellow" v-if="abandoned != '-'">
    <span class="info-box-icon metricas-info-box-icon"><i class="fa fa-close"></i></span>
    <div class="info-box-content metricas-info-box-content">
      <span class="info-box-text metricas-info-box-text">Abandoned</span>
      <span class="info-box-number metricas-info-box-number">@{{ abandoned }}</span>
    </div>
  </div>
  <div v-else="abandoned = '-'">@include('layout.recursos.loading_bar')</div>
</div>
