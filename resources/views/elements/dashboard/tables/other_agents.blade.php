<div class="row-fluid">
  <div class="col-md-12">
    <div class="box box-primary box-solid dashboard-box">
      <div class="box-header with-border dashboard-box-header">
        <h3 class="dashboard-title">Details Agents Connect</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" @click="refreshDetailsCalls()" data-toggle="tooltip" title="Refresh"><i class="fa fa-refresh"></i>
          </button>
        </div>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table align="center" class="table table-responsive table-condensed text-center">
            <thead>
              <tr>
                <th>#</th>
                <th>Agent</th>
                <th>Annexed</th>
                <th>Evento</th>
                <th>Total Duration</th>
                <th>Total Calls</th>
              </tr>
            </thead>
            <tbody>
              <template v-for="(other, index) in others ">
                @{{ searchInformationProfile(other,index,'others') }}
                <tr v-if="compareRole(other.role) === true" >
                  <td style="vertical-align: middle">@{{ index + 1 }}</td>
                  <td style="vertical-align: middle"  class="products-list product-list-in-box">
                    <div class="product-img">
                      <img :src="'storage/' + other.avatar" alt="user-img" class="img-circle">
                    </div>
                    <div class="product-info" style="text-align: left">
                      @{{ other.nameComplete }}
                      <small class="product-description">
                        <i :class ="((other.agent_status == 0 && other.event_id != 11 && other.agent_role == 'user')? 'fa fa-circle text-green' : other.event_id != 11 && other.agent_role == 'user'? 'fa fa-circle text-red' : '')"></i>
                        @{{  other.role.charAt(0).toUpperCase() + other.role.slice(1) }}
                      </small>
                    </div>
                  </td>
                  <td style="vertical-align: middle">
                    @{{ other.agent_annexed }}</td>
                  <td style="vertical-align: middle">
                    <span :class ="'label label-' + other.color">
                      <i :class ="other.icon" style="padding: 1px;" aria-hidden="true"></i>
                      @{{ searchNameEvent(other.event_id) }}
                    </span>
                  </td>
                  <td style="vertical-align: middle">@{{ other.timeElapsed }}</td>
                  <td style="vertical-align: middle">@{{ other.total_calls }}</td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>
