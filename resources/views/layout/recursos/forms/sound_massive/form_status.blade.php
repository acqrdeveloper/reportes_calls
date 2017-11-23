<!-- Modal content-->
<div class="panel panel-primary">
    <div class="panel-heading">
        <button type="button" class="close" onclick="clearModalClose('modalAsterisk', 'div.dialogAsterisk')" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change Status SoundMassive</h4>
    </div>
    <div class="modal-body">
        <form id="formSoundMassiveStatus">
            <span class="text-bold">¿ Deseas cambiar al estado {{ ($Status == 1 ? 'Inactivo' : 'Activo') }}?</span><br><br>
            @if($Status == 2)
                <span>Por lo tanto si <b>{{ $nameSoundMassive }}</b> se cambia a <label class="label label-success">Activo</label></span> todos los demas masivos parasaran a estar <label class="label label-danger">Inactivos</label>.</span><br><br>
            @else
                <span>Por lo tanto <b>{{ $nameSoundMassive }}</b> pasara al estado <label class="label label-danger">Inactivo</label>.</span><br><br>
            @endif
            <span class="text-bold">* Recuerda que solo se activa un masivo a la vez.</span>
            <div class="alert alert-danger formError" style="display: none"></div>
            <input type="hidden" name="soundMassiveID" value="{{ $idSoundMassive }}">
            <input type="hidden" name="statusSoundMassive" value="{{ $Status }}">
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btnForm"><i class="fa fa-check"></i> Si</button>
                <button type="submit" class="btn btn-info btnLoad" style="display: none"><i class="fa fa-spin fa-spinner"></i> Cargando</button>
                <button type="button" class="btn btn-danger" onclick="clearModalClose('modalAsterisk', 'div.dialogAsterisk')" data-dismiss="modal"><i class="fa fa-close"></i> No</button>
            </div>
        </form>
    </div>
</div>
{!!Html::script('js/form/formSoundMassive.min.js?version='.date('YmdHis')) !!}
<script>
    hideErrorForm('.formError')
    clearModalClose('modalAsterisk', 'div.dialogAsterisk')
</script>