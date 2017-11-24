<!-- Modal content-->
<div class="panel panel-primary">
    <div class="panel-heading">
        <button type="button" class="close" onclick="clearModalClose('modalTask', 'div.dialogTask')" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Task Manager [{{ $titleTask }}]</h4>
    </div>
    <div class="modal-body">
        <div id="formTaskQueues">
            <div class="col-xs-12">
                <div class="col-xs-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h5>1° Crear archivo para el Asterisk</h5>
                        </div>
                        <div class="panel-body bodyTastOne">
                            <h1 class="text-center text-primary" v-if="statusTaskOne === 'wait'"><i class="fa fa-hourglass"></i></h1>
                            <h1 class="text-center text-blue" v-if="statusTaskOne === 'load'"><i class="fa fa-cog fa-spin"></i></h1>
                            <h1 class="text-center text-success" v-if="statusTaskOne === 'success'"><i class="fa fa-check"></i></h1>
                            <h1 class="text-center text-danger" v-if="statusTaskOne === 'error'"><i class="fa fa-times"></i></h1>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h5>2° Moviendo hacia el Asterisk</h5>
                        </div>
                        <div class="panel-body bodyTastTwo">
                            <h1 class="text-center text-primary" v-if="statusTaskTwo === 'wait'"><i class="fa fa-hourglass"></i></h1>
                            <h1 class="text-center text-blue" v-if="statusTaskTwo === 'load'"><i class="fa fa-cog fa-spin"></i></h1>
                            <h1 class="text-center text-success" v-if="statusTaskTwo === 'success'"><i class="fa fa-check"></i></h1>
                            <h1 class="text-center text-danger" v-if="statusTaskTwo === 'error'"><i class="fa fa-times"></i></h1>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h5>3° Ejecutar reload al Asterisk</h5>
                        </div>
                        <div class="panel-body bodyTastThree">
                            <h1 class="text-center text-primary" v-if="statusTaskThree === 'wait'"><i class="fa fa-hourglass"></i></h1>
                            <h1 class="text-center text-blue" v-if="statusTaskThree === 'load'"><i class="fa fa-cog fa-spin"></i></h1>
                            <h1 class="text-center text-success" v-if="statusTaskThree === 'success'"><i class="fa fa-check"></i></h1>
                            <h1 class="text-center text-danger" v-if="statusTaskThree === 'error'"><i class="fa fa-times"></i></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="alert alert-danger" v-if="statusTaskOne === 'error' || statusTaskTwo === 'error' || statusTaskThree === 'error'">
                    <span class="fa fa-close"></span> <strong>Hubo algunos problemas al ejecutar la tarea, ejecutala nuevamente</strong>
                </div>
                <div class="alert alert-success" v-if="(statusTaskOne === 'success') && (statusTaskTwo === 'success') && (statusTaskThree === 'success')">
                    <span class="fa fa-check"></span> <strong>Se realizaron las tareas correctamente, ya puedes cerrar esta ventana</strong>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btnForm" v-on:click="deployTask()" v-if="(statusTaskOne != 'success' || statusTaskTwo != 'success' || statusTaskThree != 'success')">
                    <span v-if="buttonTask == 'wait'"><i class='fa fa-refresh'></i> Ejecutar</span>
                    <span v-if="buttonTask == 'load'"><i class="fa fa-spin fa-spinner"></i> Cargando</span>
                </button>
                <button type="button" class="btn btn-default" onclick="clearModalClose('modalTask', 'div.dialogTask')" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>
{!! Html::script('js/taskqueueVue.min.js') !!}
<script>
    clearModalClose('modalTask', 'div.dialogTask')
</script>