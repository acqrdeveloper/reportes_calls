<!-- Modal content-->
<div class="panel panel-primary">
    <div class="panel-heading">
        <button type="button" class="close" onclick="clearModalClose('modalAsterisk', 'div.dialogAsterisk')">&times;</button>
        <h4 class="modal-title">Modal - Eliminar Registro de Llamada Encolada</h4>
    </div>
    <div class="modal-body">
        <form id="formTemplateEncoladas">
            @if(isset($message))
                <p>{{$message}}</p>
            @else
                <span>¿ Está seguro de eliminar esta llamada encolada con el numero: <b>{{ $phone }}</b>?</span>
                <div class="alert alert-danger formError" style="display: none"></div>
                <input type="hidden" name="encoladaId" value="{{ $idTemplateQueue }}">
            @endif
            <div class="modal-footer">
                <button type="submit" class="btn btn-info btnLoad" style="display: none"><i class="fa fa-spin fa-spinner"></i> Cargando</button>
                @if(isset($message))
                    <button type="button" class="btn btn-danger" onclick="clearModalClose('modalAsterisk', 'div.dialogAsterisk')" data-dismiss="modal"><i class="fa fa-close"></i> Salir</button>
                @else
                    <button type="submit" class="btn btn-success btnForm"><i class="fa fa-check"></i> Si</button>
                    <button type="button" class="btn btn-danger" onclick="clearModalClose('modalAsterisk', 'div.dialogAsterisk')" data-dismiss="modal"><i class="fa fa-close"></i> No</button>
                @endif
            </div>
        </form>
    </div>
</div>
{!!Html::script('js/form/formTemplateEncoladas.min.js?version='.date('YmdHis')) !!}
<script>
    hideErrorForm('.formError')
    clearModalClose('modalAsterisk', 'div.dialogAsterisk')
</script>