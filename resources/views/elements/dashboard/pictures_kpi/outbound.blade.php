<div class="col-md-2 col-sm-6 col-xs-6" @click="loadMetricasKpi">
  <div class="info-box bg-yellow" v-if="outbound != '-'">
    <span class="info-box-icon metricas-info-box-icon"><i class="fa fa-out"></i></span>
    <div class="info-box-content metricas-info-box-content" >
    	<span class="info-box-text metricas-info-box-text">Outbound</span>
    	<span class="info-box-number metricas-info-box-number">@{{ $Salientes }}</span>
    </div>
  </div>
  <div v-else="outbound = '-'">@include('layout.recursos.loading_bar')</div>
</div>
