<!-- Modal -->
<div :class="ModalChangeStatus" data-backdrop="static" data-keyboard="false" role="dialog" v-if="ModalChangeStatus !== 'modal fade'">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="panel panel-primary">
            <div class="panel-heading">
                <button type="button" class="close" @click="ModalChangeStatus = 'modal fade'">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Cambio de Estado</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <template v-for="getListEvent in getListEvents">
                        <div class="col-md-3" data-toggle="tooltip" :title="getListEvent.name" style="margin-bottom: 10px;"
                        v-if="getListEvent.estado_visible_id == '1'  && getEventId != '11'">
                            <a href="#" @click="changeStatus(getListEvent.id,getListEvent.name,getListEvent.estado_call_id)">
                            <span :class=" 'info-box-icon bg-' + getListEvent.color " style="width:100%; height: 100%">
                                <i :class="getListEvent.icon"></i>
                            </span>
                            </a>
                        </div>

                        <div v-if="getListEvent.id == '1'  && getEventId == '11'">
                            <div class="col-md-3" data-toggle="tooltip" :title="getListEvent.name" style="margin-bottom: 10px;">
                                <a href="#" @click="changeStatus(getListEvent.id,getListEvent.name,getListEvent.estado_call_id)">
                                    <span :class=" 'info-box-icon bg-' + getListEvent.color " style="width:100%; height: 100%">
                                        <i :class="getListEvent.icon"></i>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
