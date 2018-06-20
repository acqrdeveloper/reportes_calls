<!-- Modal content-->
<div class="panel panel-primary">
    <div class="panel-heading">
        <button type="button" class="close" onclick="clearModalClose('modalUsers', 'div.dialogUsers')">&times;</button>
        <h4 class="modal-title">View Queues [{{ $User['primer_nombre'].' '.$User['apellido_paterno'] }}]</h4>
    </div>
    <div class="modal-body" id="userQueueView">
        <div class="alert alert-success text-center" v-if="UserQueue.length == 0">
            <i class="fa fa-spin fa-spinner"></i> Cargando Colas
        </div>
        <table class="table table-bordered" v-if="UserQueue.length > 0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Queue</th>
                    <th>Priority</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(queuesUser, index) in UserQueue">
                    <td v-text="index + 1"></td>
                    <td v-text="queuesUser['Queues']['name']"></td>
                    <td>
                        <div class="progress progress-xs">
                            <div :class="[ 'progress-bar progress-bar-' + getColorPercentageOfWeightUserQueue[index] ]" :style="{ width: getPercentageOfWeightUserQueue[index] + '%' }"></div>
                        </div>
                    </td>
                    <td><span :class="[ 'badge bg-' + getColorBadgeOfWeightUserQueue[index] ]" v-text="getPercentageOfWeightUserQueue[index] + ' %'"></span></td>
                </tr>
            </tbody>
        </table>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="clearModalClose('modalUsers', 'div.dialogUsers')" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
        </div>
    </div>
</div>
{!!Html::script('js/viewuserqueueVue.min.js?version='.date('YmdHis')) !!}
<script>
    clearModalClose('modalUsers', 'div.dialogUsers')
    userQueueView.idUser = 0
    userQueueView.idUser = {{ $User['id'] }}
    userQueueView.getQueue()
</script>