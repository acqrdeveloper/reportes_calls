<div class="row-fluid" v-show="callsInbound.length != 0">
  <div class="col-md-12">
    <div class="box box-primary box-solid">
      <div class="box-header with-border ">
        <h3 class="dashboard-title">Details Calls Inbound</h3>
        <div class="box-tools pull-right">
         <button type="button" class="btn btn-box-tool" data-widget="collapse" @click="refreshDetailsCalls()" data-toggle="tooltip" title="Refresh"><i class="fa fa-refresh"></i>
         </button>
        </div>
      </div>

      <div class="box-body">
        <div class="table-responsive" id =>
          <table align="center" class="table table-responsive table-condensed table-hover text-center">
            <thead>
              <tr>
                <th>#</th>
                <th>Agent</th>
                <th>Annexed</th>
                <th>Status</th>
                <th>Queue</th>
                <th>Phone Number</th>
                <th>Total Duration</th>
                <th>Total Calls</th>
              </tr>
            </thead>
            <tbody>
              <template v-for="(inbound, index) in callsInbound ">
                @{{ searchInformationProfile(inbound,index, 'callsInbound') }}
                <tr v-if="compareRole(inbound.role) === true">
                  <td>@{{ index + 1 }}</td>
                  <td class="products-list product-list-in-box">
                    <div class="product-img">
                      <img :src="'storage/' + inbound.avatar" alt="user-img" class="img-circle">
                    </div>
                    <div class="product-info" style="text-align: left">
                      @{{ inbound.nameComplete }}
                      <small class="product-description">
                        <i :class ="((inbound.agent_status == 0 && inbound.event_id != 11 && inbound.agent_role == 'user')? 'fa fa-circle text-green' : inbound.event_id != 11 && inbound.agent_role == 'user'? 'fa fa-circle text-red' : '')"></i>
                        @{{  inbound.role.charAt(0).toUpperCase() + inbound.role.slice(1) }}
                      </small>
                    </div>
                  </td>
                  <td>
                    @{{ inbound.agent_annexed }}
                  </td>
                  <td>
                    <span :class ="'label label-' + inbound.color">
                      <i :class ="inbound.icon" style="padding: 1px;" aria-hidden="true"></i>
                      @{{ searchNameEvent(inbound.event_id) }}
                    </span>
                  </td>
                  <td>@{{ inbound.inbound_queue }}</td>
                  <td>@{{ inbound.inbound_phone  }}</td>
                  <td>@{{ inbound.timeElapsed }}</td>
                  <td>@{{ inbound.total_calls }}</td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
