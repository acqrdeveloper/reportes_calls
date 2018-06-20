<!-- Modal content-->
<div class="panel panel-primary">
    <div class="panel-heading">
        <button type="button" class="close" onclick="clearModalClose('modalAsterisk', 'div.dialogAsterisk')" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{ $updateForm === true ? "Edit" : "Add" }} Queue</h4>
    </div>
    <div class="modal-body">
        @if($countTemplateQueues > 0)
        <form id="formQueues">
            <div class="form-group">
                <label>Name Queue</label>
                <input type="text" name="nameQueue" class="form-control" placeholder="Enter Name Queue" value="{{ $nameQueue }}">
            </div>
            <div class="form-group">
                <label>VDN</label>
                <input type="text" name="numVdn" class="form-control" placeholder="Enter number VDN" value="{{ $numVdn }}" onkeypress="return filterNumber(event)" onkeydown="return BlockCopyPaste(event)" {!! $updateForm === true ? 'readonly="readonly"' : '' !!}>
            </div>
            <div class="form-group">
                <label>Strategy</label>
                <select id="selectedStrategy" name="selectedStrategy" class="form-control">
                    @foreach ($optionsStrategy as $strategy)
                        <option value="{{ $strategy['id'] }}" {{ $strategy['id'] === $selectedStrategy ? "selected" : "" }} data-name="{{ $strategy['name'] }}">{{ $strategy['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Priority</label>
                <select name="selectedPriority" class="form-control">
                    @foreach ($optionsPriority as $priority)
                        <option value="{{ $priority['id'] }}" {{ $priority['id'] === $selectedPriority ? "selected" : "" }}>{{ $priority['description'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Templates</label>
                <select name="selectedTemplate" class="form-control">
                    @foreach ($optionsTemplate as $template)
                        <option value="{{ $template['id'] }}" {{ $template['id'] === $selectedTemplate ? "selected" : "" }}>{{ $template['name_template'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>N° Limit Call Waiting</label>
                <input type="text" name="limitCallWaiting" class="form-control" placeholder="Enter Limit Call Waiting" value="{{ $numLimitCallWaiting }}" onkeypress="return filterNumber(event)" onkeydown="return BlockCopyPaste(event)">
            </div>
            <div class="form-group">
                <label>Music Choose</label>
                <select id="selectedMusic" name="selectedMusic" class="form-control">
                    @foreach ($optionsMusic as $music)
                        <option value="{{ $music['id'] }}" {{ $music['id'] === $selectedMusic ? "selected" : "" }} data-route="{{ $music['route_music'] }}">{{ $music['name_music'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <audio id="audioTag" controls="controls" style="width: 100%">
                    <source src="" type="audio/mp3" />
                    Your browser does not support the audio element.
                </audio>
            </div>

            @include('layout.recursos.forms.queues.legendQueue.legendQueue')

            <div class="alert alert-danger formError" style="display: none"></div>
            <input type="hidden" name="queueID" value="{{ $idQueue }}">
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnForm">{!! $updateForm === true ? "<i class='fa fa-edit'></i> Editar" : "<i class='fa fa-plus'></i> Agregar" !!}</button>
                <button type="submit" class="btn btn-info btnLoad" style="display: none"><i class="fa fa-spin fa-spinner"></i> Cargando</button>
                <button type="button" class="btn btn-default" onclick="clearModalClose('modalAsterisk', 'div.dialogAsterisk')" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </form>
        @else
            <div class="alert alert-warning">
                <span class="fa fa-warning"></span> <strong>Debes tener por lo menos un template creado y/o habilitado para crear y/o editar una cola.</strong>
            </div>
        @endif
    </div>
</div>
{!!Html::script('js/form/formQueues.min.js?version='.date('YmdHis')) !!}
<script>
    hideErrorForm('.formError')
    loadRouteMusic('#selectedMusic','#audioTag')
    loadSelectStrategy('#selectedStrategy')
    searchLegendQueue('#selectedStrategy')
    searchRouteMusic('#selectedMusic','#audioTag')
    clearModalClose('modalAsterisk', 'div.dialogAsterisk')
</script>