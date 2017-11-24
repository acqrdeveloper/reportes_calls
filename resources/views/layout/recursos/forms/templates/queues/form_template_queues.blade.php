<!-- Modal content-->
<div class="panel panel-primary">
    <div class="panel-heading">
        <button type="button" class="close" onclick="clearModalClose('modalAsterisk', 'div.dialogAsterisk')" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{ $updateForm === true ? "Edit" : "Add" }} Template Queue</h4>
    </div>
    <div class="modal-body">
        @if($countMusicOnHold > 0)
        <form id="formTemplateQueues">
            <div class="form-group">
                <label>Name Template Queue</label>
                <input type="text" name="nameQueue" class="form-control" placeholder="Enter Name Template Queue" value="{{ $nameTemplateQueue }}">
            </div>
            <div class="form-group">
                <label>Music On Hold</label>
                <select id="selectedMusicOnHold" name="selectedMusicOnHold" class="form-control">
                    @foreach ($optionsMusicOnHold as $musicOnHold)
                        <option value="{{ $musicOnHold['id'] }}" {{ $musicOnHold['id'] === $selectedMusicOnHold ? "selected" : "" }} data-name="{{ $musicOnHold['name_music'] }}">{{ $musicOnHold['name_music'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="alert alert-danger formError" style="display: none"></div>
            <input type="hidden" name="templateQueueID" value="{{ $idTemplateQueue }}">
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnForm">{!! $updateForm === true ? "<i class='fa fa-edit'></i> Editar" : "<i class='fa fa-plus'></i> Agregar" !!}</button>
                <button type="submit" class="btn btn-info btnLoad" style="display: none"><i class="fa fa-spin fa-spinner"></i> Cargando</button>
                <button type="button" class="btn btn-default" onclick="clearModalClose('modalAsterisk', 'div.dialogAsterisk')" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </form>
        @else
            <div class="alert alert-warning">
                <span class="fa fa-warning"></span> <strong>Debes tener por lo menos un music on hold creado y/o habilitado para crear y/o editar un template.</strong>
            </div>
        @endif
    </div>
</div>
{!!Html::script('js/form/formTemplateQueues.min.js?version='.date('YmdHis')) !!}
<script>
    hideErrorForm('.formError')
    clearModalClose('modalAsterisk', 'div.dialogAsterisk')
</script>