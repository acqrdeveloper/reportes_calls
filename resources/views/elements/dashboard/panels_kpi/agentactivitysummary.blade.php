<div class="row-fluid" id='detailAgents'>
		<div class="box box-primary box-solid dashboard-box">
			<div class="box-header with-border dashboard-box-header">
		  	<h3 class="dashboard-title">Agent Activity Summary</h3>
			</div>
			<div class="box-body" v-for="agentStatus in agentStatusSummary" style="padding: 0px">
				<div class="col-md-12">
					<ul class="products-list product-list-in-box">
		        		<li class="item">
		          			<div class="product-img">
		              			<i :class="agentStatus.icon + ' fa-2x'"></i>
		          			</div>
							<div class="product-info" >
		              		<label>@{{ agentStatus.event_name  }}</label>
		              			<span :class="'label label-' + agentStatus.color + ' pull-right'" style="font-size:15px">@{{ agentStatus.quantity  }}</span>
		          			</div>
		        		</li>
		      		</ul>
				</div>
			</div>
		</div>
</div>
