<!-- Modal content-->
<form id="formCreateSoundMassive">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <button type="button" class="close" onclick="clearModalClose('modalAsterisk', 'div.dialogAsterisk')" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Nuevo</h4>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger formError" style="display: none"></div>
            <div class="form-group">
                <label>Nombre</label>
                <input name="name_massive" type="text" class="form-control">
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success btnForm"><i class="fa fa-check"></i> Crear</button>
            <button type="button" class="btn btn-info btnLoad" style="display: none"><i class="fa fa-spin fa-spinner"></i> Cargando</button>
            <button type="button" class="btn btn-danger" onclick="clearModalClose('modalAsterisk', 'div.dialogAsterisk')" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
        </div>
    </div>
</form>
{!!Html::script('js/form/sound_massive/formCreate.min.js?version='.date('YmdHis')) !!}
<script>
  hideErrorForm('.formError')
  clearModalClose('modalAsterisk', 'div.dialogAsterisk')
</script>