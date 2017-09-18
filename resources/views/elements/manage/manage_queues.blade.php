<input type="hidden" name="_token" value="{!! csrf_token() !!}">

<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">@yield('titleReport')</h3>
        <div class="box-tools">
            <div class="btn-group pull-right">
                <a onclick="responseModal('div.dialogQueues','form_queues')" data-toggle="modal" data-target="#modalQueues" class="btn btn-primary"><i class="fa fa-user-plus" aria-hidden="true" ></i> Add Queue</a>
            </div>
        </div>
    </div>
    <div class="box-body">
        <table id="table-list-queue" class="table table-bordered display nowrap table-responsive" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name Queue</th>
                    <th>Vdn</th>
                    <th>Strategy</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@include('layout.recursos.modals.modal_queues')

<script type="text/javascript">
    $(document).ready(function(){
        buscar()
    })
    function buscar(){
        showTabListQueues('manage_queues')
    }
</script>