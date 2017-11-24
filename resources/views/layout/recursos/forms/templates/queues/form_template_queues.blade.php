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
                <input type="text" name="nameTemplateQueue" class="form-control" placeholder="Enter Name Template Queue" value="{{ $nameTemplateQueue }}" onkeypress="return filterLetter(event)" onkeydown="return BlockCopyPaste(event)">
            </div>
            <div class="form-group">
                <label>Music On Hold</label>
                <select id="selectedMusicOnHold" name="selectedMusicOnHold" class="form-control">
                    @foreach ($optionsMusicOnHold as $musicOnHold)
                        <option value="{{ $musicOnHold['id'] }}" {{ $musicOnHold['id'] === $selectedMusicOnHold ? "selected" : "" }} data-name="{{ $musicOnHold['name_music'] }}">{{ $musicOnHold['name_music'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Join Empty</label>
                <select id="selectedJoinEmpty" name="selectedJoinEmpty" class="form-control">
                    <option value="yes" {{ $selectedJoinEmpty === 'yes' ? "selected" : "" }}>yes</option>
                    <option value="no" {{ $selectedJoinEmpty === 'no' ? "selected" : "" }}>no</option>
                </select>
            </div>
            <div class="form-group">
                <label>TimeOut</label>
                <input type="text" name="timeOut" class="form-control" placeholder="Enter Number TimeOut" value="{{ $timeOut }}" onkeypress="return filterNumber(event)" onkeydown="return BlockCopyPaste(event)">
            </div>
            <div class="form-group">
                <label>Member Delay</label>
                <input type="text" name="memberDelay" class="form-control" placeholder="Enter Number Member Delay" value="{{ $memberDelay }}" onkeypress="return filterNumber(event)" onkeydown="return BlockCopyPaste(event)">
            </div>
            <div class="form-group">
                <label>Ring In Use</label>
                <select id="selectedRingInUse" name="selectedRingInUse" class="form-control">
                    <option value="yes" {{ $selectedRingInUse === 'yes' ? "selected" : "" }}>yes</option>
                    <option value="no" {{ $selectedRingInUse === 'no' ? "selected" : "" }}>no</option>
                </select>
            </div>
            <div class="form-group">
                <label>AutoPause</label>
                <select id="selectedAutoPause" name="selectedAutoPause" class="form-control">
                    <option value="yes" {{ $selectedAutoPause === 'yes' ? "selected" : "" }}>yes</option>
                    <option value="no" {{ $selectedAutoPause === 'no' ? "selected" : "" }}>no</option>
                </select>
            </div>
            <div class="form-group">
                <label>AutoPause Busy</label>
                <select id="selectedAutoPauseBusy" name="selectedAutoPauseBusy" class="form-control">
                    <option value="yes" {{ $selectedAutoPauseBusy === 'yes' ? "selected" : "" }}>yes</option>
                    <option value="no" {{ $selectedAutoPauseBusy === 'no' ? "selected" : "" }}>no</option>
                </select>
            </div>
            <div class="form-group">
                <label>Wrap Uptime</label>
                <input type="text" name="wrapUptime" class="form-control" placeholder="Enter Number Wrap Uptime" value="{{ $wrapUptime }}" onkeypress="return filterNumber(event)" onkeydown="return BlockCopyPaste(event)">
            </div>
            <div class="form-group">
                <label>Max Len</label>
                <input type="text" name="maxLen" class="form-control" placeholder="Enter Number Max Len" value="{{ $maxLen }}" onkeypress="return filterNumber(event)" onkeydown="return BlockCopyPaste(event)">
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