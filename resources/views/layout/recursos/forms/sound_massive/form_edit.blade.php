<!-- Modal content-->
<form id="formEditSoundMassive">
    <input type="hidden" name="sound_massive_id" value="{{ $dataSM->id }}">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <button type="button" class="close" onclick="clearModalClose('modalAsterisk', 'div.dialogAsterisk')"
                    data-dismiss="modal">&times;
            </button>
            <h4 class="modal-title">Editar</h4>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger formError" style="display: none"></div>
            <div class="form-group">
                <label>Nombre</label>
                <input name="name_massive" type="text" class="form-control" value="{{$dataSM->name_massive}}">
            </div>
            <div class="form-group">
                <label>Estado</label>
                <select name="state" class="form-control">
                @if($dataSM->state_masive == 1 && $dataSM->state_ivr == 2)<!--con audio-->
                    @foreach($allStatus as $k => $v)
                        @if($k == 1)
                            <option value="{{$k}}" selected>{{$v}}</option>
                        @else
                            <option value="{{$k}}">{{$v}}</option>
                        @endif
                    @endforeach
                @elseif($dataSM->state_masive == 2 && $dataSM->state_ivr == 1)<!--sin audio-->
                    @foreach($allStatus as $k => $v)
                        @if($k ==  2)
                            <option value="{{$k}}" selected>{{$v}}</option>
                        @else
                            <option value="{{$k}}">{{$v}}</option>
                        @endif
                    @endforeach
                @elseif($dataSM->state_masive == 2 && $dataSM->state_ivr == 2)
                        @foreach($allStatus as $k => $v)
                            @if($k == 3)
                                <option value="{{$k}}" selected>{{$v}}</option>
                            @else
                                <option value="{{$k}}">{{$v}}</option>
                            @endif
                        @endforeach
                    @endif

                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success btnForm"><i class="fa fa-check"></i> Actualizar</button>
            <button type="button" class="btn btn-info btnLoad" style="display: none"><i
                        class="fa fa-spin fa-spinner"></i> Cargando
            </button>
            <button type="button" class="btn btn-danger"
                    onclick="clearModalClose('modalAsterisk', 'div.dialogAsterisk')" data-dismiss="modal"><i
                        class="fa fa-close"></i> Cancelar
            </button>
        </div>
    </div>
</form>
{!!Html::script('js/form/sound_massive/formEdit.min.js?version='.date('YmdHis')) !!}
<script>
  hideErrorForm('.formError')
  clearModalClose('modalAsterisk', 'div.dialogAsterisk')
</script>