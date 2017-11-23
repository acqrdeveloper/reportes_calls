<!-- Modal content-->
<div class="panel panel-primary">
    <div class="panel-heading">
        <button type="button" class="close" onclick="clearModalClose('modalAsterisk', 'div.dialogAsterisk')">&times;</button>
        <h4 class="modal-title">Change Status Queue [{{ $nameQueue }}]</h4>
    </div>
    <div class="modal-body">
        <form id="formQueuesStatus">
            <span>¿ Deseas cambiar al estado {{ ($Status == 1 ? 'Inactivo' : 'Activo') }}?</span>
            <div class="alert alert-danger formError" style="display: none"></div>
            <input type="hidden" name="queueID" value="{{ $idQueue }}">
            <input type="hidden" name="statusQueue" value="{{ $Status }}">
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btnForm"><i class="fa fa-check"></i> Si</button>
                <button type="submit" class="btn btn-info btnLoad" style="display: none"><i class="fa fa-spin fa-spinner"></i> Cargando</button>
                <button type="button" class="btn btn-danger" onclick="clearModalClose('modalAsterisk', 'div.dialogAsterisk')" data-dismiss="modal"><i class="fa fa-close"></i> No</button>
            </div>
        </form>
    </div>
</div>
{!!Html::script('js/form/formQueues.min.js?version='.date('YmdHis')) !!}
<script>
    hideErrorForm('.formError')
    clearModalClose('modalAsterisk', 'div.dialogAsterisk')
</script>