<div class="row-fluid" id='detailAgents'>
    <div class="box box-primary box-solid dashboard-box">
        <div class="box-header with-border dashboard-box-header">
            <h3 class="dashboard-title">Filter Dashboard</h3>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                <v-select multiple :value.sync="filterRoles" :on-change="loadRolePermission" :options="['Admin','Supervisor','Backoffice','Calidad','Cliente','User']" placeholder="Choose Role Here !"></v-select>
            </div>
        </div>
    </div>
</div>
