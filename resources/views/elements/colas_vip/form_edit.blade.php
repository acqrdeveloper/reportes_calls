<!-- Modal content-->
<form id="formEditVip">
    <input type="hidden" name="queue_vip_id" value="{{ $dataVip->id }}">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <button type="button" class="close" onclick="clearModalClose('modalAsterisk', 'div.dialogAsterisk')" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Editar Cola Vip</h4>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger formError" style="display: none"></div>
            <div class="form-group">
                <label>Nombre Cola Vip</label>
                <input name="name" type="text" class="form-control" value="{{ $dataVip->name }}">
            </div>
            <div class="form-group">
                <label>Numero Telefono</label>
                <input name="number_telephone" type="text" class="form-control" value="{{ $dataVip->number_telephone }}">
            </div>
            <div class="form-group">
                <label>Seleccionar Cola</label>
                <select name="queue_id" class="form-control">
                @foreach($dataQueue as $k => $v)
                    @if($v->id == $dataVip->queue_id)
                    <option value="{{$v->id}}" selected>{{$v->name}}</option>
                    @else
                    <option value="{{$v->id}}">{{$v->name}}</option>
                    @endif
                @endforeach
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success btnForm"><i class="fa fa-check"></i> Actualizar Cola Vip</button>
            <button type="button" class="btn btn-info btnLoad" style="display: none"><i class="fa fa-spin fa-spinner"></i> Cargando</button>
            <button type="button" class="btn btn-danger" onclick="clearModalClose('modalAsterisk', 'div.dialogAsterisk')" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
        </div>
    </div>
</form>
{!!Html::script('js/form/colas_vip/formEdit.min.js?version='.date('YmdHis')) !!}
<script>
  hideErrorForm('.formError')
  clearModalClose('modalAsterisk', 'div.dialogAsterisk')
</script>