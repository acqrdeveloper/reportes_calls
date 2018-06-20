<div class="col-md-2 col-sm-6 col-xs-6" @click="loadMetricasKpi">
  <div class="info-box bg-red" v-if="abandonedTime != '-'">
    <span class="info-box-icon metricas-info-box-icon"><i class="fa fa-sign-out"></i></span>
    <div class="info-box-content metricas-info-box-content" >
    	<span class="info-box-text metricas-info-box-text">Abandoned @{{ abandonedSymbol }} @{{ abandonedSecond }} Seg</span>
    	<span class="info-box-number metricas-info-box-number">@{{ abandonedTime }}</span>
    </div>
  </div>
  <div v-else="abandonedTime = '-'">@include('layout.recursos.loading_bar')</div>
</div>
