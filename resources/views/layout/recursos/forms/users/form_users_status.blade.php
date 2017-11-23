<!-- Modal content-->
<div class="panel panel-primary">
    <div class="panel-heading">
        <button type="button" class="close" onclick="clearModalClose('modalUsers', 'div.dialogUsers')" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change Status [{{ $User['username'] }}]</h4>
    </div>
    <div class="modal-body">
        <form id="formChangeStatus">
            <span>¿Deseas cambiar a {{ $User['primer_nombre'].' '.$User['apellido_paterno'] }}, al estado {{ ($User['estado_id'] == 1 ? 'Inactivo' : 'Activo') }} ?</span>
            <div class=" alert alert-danger formError" style="display: none"></div>
            <input type="hidden" name="userID" value="{{ $idUser }}">
            <input type="hidden" name="statusUser" value="{{ $User['estado_id'] }}">
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnForm"><i class='fa fa-refresh'></i> Cambiar</button>
                <button type="submit" class="btn btn-info btnLoad" style="display: none"><i class="fa fa-spin fa-spinner"></i> Cargando</button>
                <button type="button" class="btn btn-default" onclick="clearModalClose('modalUsers', 'div.dialogUsers')" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </form>
    </div>
</div>
{!!Html::script('js/form/formUsers.min.js?version='.date('YmdHis')) !!}
<script>
    hideErrorForm('.formError')
    clearModalClose('modalUsers', 'div.dialogUsers')
</script>