<!-- Modal content-->
<div class="panel panel-primary">
    <div class="panel-heading">
        <button type="button" class="close" onclick="clearModalClose('modalUsers', 'div.dialogUsers')" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change Role [{{ $User['username'] }}]</h4>
    </div>
    <div class="modal-body">
        <form id="formChangeRole">
            <h5 class="text-center">Seleccione el rol que se cambiara al usuario :</h5>
            <div class="form-group col-md-12">
                <div class="col-md-6">
                <div class="input-group">
                    <div class="input-group-addon">
                        <input type="radio" name="nameRole" value="user" @if($User['role'] == 'user') checked @endif>
                    </div>
                    <div class="form-control">
                        User
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-group-addon">
                        <input type="radio" name="nameRole" value="supervisor" @if($User['role'] == 'supervisor') checked @endif>
                    </div>
                    <div class="form-control">
                        Supervisor
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-group-addon">
                        <input type="radio" name="nameRole" value="backoffice" @if($User['role'] == 'backoffice') checked @endif>
                    </div>
                    <div class="form-control">
                        BackOffice
                    </div>
                </div>
                </div>
                <div class="col-md-6">
                <div class="input-group">
                    <div class="input-group-addon">
                        <input type="radio" name="nameRole" value="calidad" @if($User['role'] == 'calidad') checked @endif>
                    </div>
                    <div class="form-control">
                        Calidad
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-group-addon">
                        <input type="radio" name="nameRole" value="cliente" @if($User['role'] == 'cliente') checked @endif>
                    </div>
                    <div class="form-control">
                        Cliente
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-12 alert alert-danger formError" style="display: none"></div>
            <input type="hidden" name="userId" value="{{ $idUser }}">
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnForm"><i class='fa fa-edit'></i> Editar</button>
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