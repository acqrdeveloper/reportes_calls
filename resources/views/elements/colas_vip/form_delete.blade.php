<!-- Modal content-->
<form id="formDeleteVip">
    <input type="hidden" name="queue_vip_id" value="{{ $dataVip->id }}">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <button type="button" class="close" onclick="clearModalClose('modalAsterisk', 'div.dialogAsterisk')" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Eliminar Cola Vip</h4>
        </div>
        <div class="modal-body">
            <span>¿Estas seguro de eliminar la cola vip <b>{{ $dataVip->name }}</b>?</span>
            <div class="alert alert-danger formError" style="display: none"></div>
            <input type="hidden" name="queue_vip_id" value="{{ $dataVip->id }}">
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success btnForm"><i class="fa fa-check"></i> Si</button>
            <button type="button" class="btn btn-info btnLoad" style="display: none"><i class="fa fa-spin fa-spinner"></i> Cargando</button>
            <button type="button" class="btn btn-danger" onclick="clearModalClose('modalAsterisk', 'div.dialogAsterisk')" data-dismiss="modal"><i class="fa fa-close"></i> No</button>
        </div>
    </div>
</form>
{!!Html::script('js/form/colas_vip/formDelete.min.js?version='.date('YmdHis')) !!}
<script>
  hideErrorForm('.formError')
  clearModalClose('modalAsterisk', 'div.dialogAsterisk')
</script>