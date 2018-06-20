<!-- Modal content-->
<div class="panel panel-default">
    <div class="panel-heading">
        <button type="button" class="close" onclick="clearModalClose('modalUsers', 'div.dialogUsers')" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change Password [{{ $User['username'] }}]</h4>
    </div>
    <div class="modal-body">
        <form id="formChangePassword">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-lock fa-fw" aria-hidden="true"></i>
                    </div>
                    <input type="password" name="newPassword" class="form-control" placeholder="Ingrese la Nueva Contraseña">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-lock fa-fw" aria-hidden="true"></i>
                    </div>
                    <input type="password" name="confirmNewPassword" class="form-control" placeholder="Repita la Nueva Contraseña">
                </div>
            </div>
            <div class="alert alert-info">
                <span class="fa fa-info-circle"></span> <strong>Tips</strong>
                <li>Una contraseña segura está compuesta de 8 a 12 caracteres.</li>
                <li>Permite números , letras y símbolos del teclado.</li>
            </div>
            <div class=" alert alert-danger formError" style="display: none"></div>
            <input type="hidden" name="userID" value="{{ $idUser }}">
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger btnForm"><i class='fa fa-edit'></i> Editar</button>
                <button type="submit" class="btn btn-primary btnLoad" style="display: none"><i class="fa fa-spin fa-spinner"></i> Cargando</button>
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