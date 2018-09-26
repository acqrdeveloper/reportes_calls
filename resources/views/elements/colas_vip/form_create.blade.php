<!-- Modal content-->
<form id="formCreateVip">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <button type="button" class="close" onclick="clearModalClose('modalAsterisk', 'div.dialogAsterisk')" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Crear Cola Vip</h4>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger formError" style="display: none"></div>
            <div class="form-group">
                <label>Nombre Cola Vip</label>
                <input name="name" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label>Numero Telefono</label>
                <input name="number_telephone" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label>Seleccionar Cola</label>
                <select name="queue_id" class="form-control">
                    @foreach($dataQueue as $k => $v)
                        <option value="{{$v->id}}">{{$v->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success btnForm"><i class="fa fa-check"></i> Crear Cola Vip</button>
            <button type="button" class="btn btn-info btnLoad" style="display: none"><i class="fa fa-spin fa-spinner"></i> Cargando</button>
            <button type="button" class="btn btn-danger" onclick="clearModalClose('modalAsterisk', 'div.dialogAsterisk')" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
        </div>
    </div>
</form>
{!!Html::script('js/form/colas_vip/formCreate.min.js?version='.date('YmdHis')) !!}
<script>
  hideErrorForm('.formError')
  clearModalClose('modalAsterisk', 'div.dialogAsterisk')
</script>