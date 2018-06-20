<div class="row-fluid" v-show="callsOutbound.length != 0">
  <div class="col-md-12">
    <div class="box box-primary box-solid">
      <div class="box-header with-border ">
        <h3 class="dashboard-title">Detail Calls Outbound</h3>
        <div class="box-tools pull-right">
         <button type="button" class="btn btn-box-tool" data-widget="collapse" @click="refreshDetailsCalls()" data-toggle="tooltip" title="Refresh"><i class="fa fa-refresh"></i>
         </button>
        </div>
      </div>
      <div class="box-body">
        <div class="table-responsive" id =>
          <table align="center" class="table table-responsive table-condensed text-center">
            <thead>
              <tr>
                <th>#</th>
                <th>Agent</th>
                <th>Annexed</th>
                <th>Evento</th>
                <th>Number Outbound</th>
                <th>Talk Time</th>
                <th>Status Time</th>
              </tr>
            </thead>
            <tbody>
              <template v-for="(outbound, index) in callsOutbound ">
                @{{ searchInformationProfile(outbound,index,'callsOutbound') }}
                <tr v-if="compareRole(outbound.role) === true">
                  <td> @{{ index + 1 }}</td>
                  <td class="products-list product-list-in-box">
                    <div class="product-img">
                      <img :src="'storage/' + outbound.avatar" alt="user-img" class="img-circle">
                    </div>
                    <div class="product-info" style="text-align: left">
                      @{{ outbound.nameComplete }}
                      <small class="product-description">
                        <i :class ="((outbound.agent_status == 0 && outbound.event_id != 11 && outbound.agent_role == 'user')? 'fa fa-circle text-green' : outbound.event_id != 11 && outbound.agent_role == 'user'? 'fa fa-circle text-red' : '')"></i>
                        @{{  outbound.role.charAt(0).toUpperCase() + outbound.role.slice(1) }}
                      </small>
                    </div>
                  </td>
                  <td>
                    @{{ outbound.agent_annexed }}
                  </td>
                  <td>
                    <span :class ="'label label-' + outbound.color">
                      <i :class ="outbound.icon" style="padding: 1px;" aria-hidden="true"></i>
                        @{{ searchNameEvent(outbound.event_id) }}
                    </span>
                  </td>
                  <td>@{{ outbound.outbound_phone }}</td>
                  <td>@{{ outbound.timeElapsed }}</td>
                  <td>@{{ outbound.timeElapsed }}</td>
                </tr>
                <tr v-if=" outbound.second_outbound_start != ''">
                  <td colspan="3">=================></td>
                  <td>@{{ outbound.second_event_name }}</td>
                  <td>@{{ outbound.second_outbound_phone }}</td>
                  <td>@{{ outbound.secondCalltimeElapsed }}</td>
                  <td>@{{ outbound.secondCalltimeElapsed }}</td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
      </div>
      <div class="overlay" v-if="callsOutbound.length === 0">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>
</div>
