<!-- Modal content-->
<div class="panel panel-primary">
    <div class="panel-heading">
        <button type="button" class="close" onclick="clearModalClose('modalUsers', 'div.dialogUsers')">&times;</button>
        <h4 class="modal-title">Assign Queues [{{ $User['primer_nombre'].' '.$User['apellido_paterno']}}]</h4>
    </div>
    <div class="modal-body">
        <form id="formAssignQueues">
            <div class="col-xs-12">
                <table class="table table-bordered table-responsive" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center col-xs-2">
                                <input type="checkbox" class="checkGeneral" onclick="mark_all('.checkGeneral')">
                            </th>
                            <th class="col-xs-8">Nombre de Queue</th>
                            <th class="col-xs-2">Prioridad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($Queues as $queue)
                            <?php $ifExistUser = (isset($queue['UserQueues']) ? true : false) ?>
                            <tr class="@if($ifExistUser) success @else info @endif @if(!$ifExistUser) trNew @endif" id="tr_{{ $queue['id'] }}">
                                <td class="col-xs-2 text-center">
                                    <input type="checkbox" name="checkQueue[]" value="{{ $queue['id'] }}" id="checkbox_{{ $queue['id'] }}" class="@if(!$ifExistUser) checkNew @endif"
                                           @if($ifExistUser)
                                               @if($queue['id'] == $queue['UserQueues']['queue_id'])
                                                checked
                                               @endif
                                           @endif onclick="markCheck('{{ $queue['id'] }}')">
                                </td>
                                <td class="col-xs-8">
                                    {{ $queue['name'] }}
                                </td>
                                <td class="col-xs-2">
                                    <select id="select_{{ $queue['id'] }}" name="selectPriority[]" class="@if(!$ifExistUser) selectNew @endif" @if(!$ifExistUser) disabled @endif>
                                        <option selected disabled> - </option>
                                        @foreach ($Priority as $priority)
                                            <option value="{{ $priority['id'] }}"
                                                    @if($ifExistUser)
                                                        @if($priority['id'] == $queue['UserQueues']['priority'])
                                                            selected
                                                        @endif
                                                    @endif>
                                                {{ $priority['description'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-xs-12 alert alert-danger formError" style="display: none"></div>
            <input type="hidden" name="userID" value="{{ $idUser }}">
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnForm"><i class="fa fa-save"></i> Guardar</button>
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