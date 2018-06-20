<div class="box box-primary box-solid dashboard-box">
  <div class="box-header with-border dashboard-box-header">
    <h3 class="dashboard-title">Group Statistics</h3> </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div class="col-md-6">
      <ul class="products-list product-list-in-box">
        <li class="item">
          <div class="product-img"> <i class="fa fa-tachometer fa-2x"></i> </div>
          <div class="product-info"
            style="margin-left: 40px;"><label>@{{ slaDay }} %</label><span class="product-description">SLA Day</span></div>
        </li>
      </ul>
    </div>
    <div class="col-md-6">
      <ul class="products-list product-list-in-box">
        <li class="item">
          <div class="product-img"> <i class="fa fa-tachometer fa-2x"></i> </div>
          <div class="product-info"
            style="margin-left: 40px;"><label>@{{ slaMonth }} %</label><span class="product-description">SLA Month</span> </div>
        </li>
      </ul>
    </div>
    <div class="col-md-6">
      <ul class="products-list product-list-in-box">
        <li class="item">
          <div class="product-img"> <i class="fa fa-weixin fa-2x"></i> </div>
          <div class="product-info"
            style="margin-left: 40px;"><label>@{{ percentageAnswer }} %</label><span class="product-description">% Answer</span></div>
        </li>
      </ul>
    </div>
    <div class="col-md-6">
      <ul class="products-list product-list-in-box">
        <li class="item">
          <div class="product-img"> <i class="fa fa-times-circle fa-2x"></i> </div>
          <div class="product-info"
            style="margin-left: 40px;"><label>@{{ percentageUnanswer }} %</label><span class="product-description">% Unanswer</span> </div>
        </li>
      </ul>
    </div>
    <div class="col-md-6">
      <ul class="products-list product-list-in-box">
        <li class="item">
          <div class="product-img"> <i class="fa fa-clock-o fa-2x"></i> </div>
          <div class="product-info"
            style="margin-left: 40px;"><label>@{{ avgWait }}</label><span class="product-description">Avg Wait</span> </div>
        </li>
      </ul>
    </div>
    <div class="col-md-6">
      <ul class="products-list product-list-in-box">
        <li class="item">
          <div class="product-img"> <i class="fa fa-hourglass-start fa-2x"></i> </div>
          <div class="product-info"
            style="margin-left: 40px;"><label>@{{ avgCallDuration }}</label><span class="product-description">Avg Call Duration</span></div>
        </li>
      </ul>
    </div>
    <div class="col-md-6">
      <ul class="products-list product-list-in-box">
        <li class="item">
          <div class="product-img"> <i class="fa fa-clock-o fa-2x"></i> </div>
          <div class="product-info"
            style="margin-left: 40px;"><label>@{{ totalCallDurationInbound }}</label><span class="product-description">Duration Inbound</span></div>
        </li>
      </ul>
    </div>
    <div class="col-md-6">
      <ul class="products-list product-list-in-box">
        <li class="item">
          <div class="product-img"> <i class="fa fa-clock-o fa-2x"></i> </div>
          <div class="product-info"
            style="margin-left: 40px;"><label>@{{ totalCallDurationOutbound }}</label><span class="product-description">Duration Outbound</span></div>
        </li>
      </ul>
    </div>
  </div>
  <!-- /.box-body -->
</div>
