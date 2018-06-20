<div class="row-fluid" v-show="callsWaiting.length != 0">
  <div class="col-md-12">
    <div class="box box-warning box-solid">
      <div class="box-header with-border ">
        <h3 class="dashboard-title">Details Encoladas</h3>
      </div>

      <div class="table-responsive">
        <table class="table table-responsive table-bordered text-center">
          <thead>
            <tr>
              <th>#</th>
              <th>Number</th>
              <th>Queue</th>
              <th>Elapsed</th>
            </tr>
          </thead>
          <tbody>
            <template v-for="(waiting, index) in callsWaiting ">
              <tr>
                <td>@{{ index + 1 }}</td>
                <td>@{{ waiting.number_phone }} - @{{ waiting.name_number }}</td>
                <td>@{{ waiting.name_queue }}</td>
                <td>@{{ waiting.timeElapsed }}</td>
                @{{ loadTimeElapsedEncoladas(index) }}
              </tr>
            </template>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
