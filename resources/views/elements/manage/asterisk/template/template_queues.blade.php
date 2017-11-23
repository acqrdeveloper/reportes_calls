<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">@yield('titleReport')</h3>
        <div class="box-tools">
            <div class="btn-group pull-right">
                <a onclick="responseModal('div.dialogAsterisk','form_queues')" data-toggle="modal" data-target="#modalAsterisk" class="btn btn-primary"><i class="fa fa-user-plus" aria-hidden="true" ></i> Add Template Queue</a>
            </div>
        </div>
    </div>
    <div class="box-body">
        <table id="table-list-template-queue" class="table table-bordered display nowrap table-responsive" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Id</th>
                <th>Name Template</th>
                <th>Music On Hold</th>
                <th>Status</th>
                <th>Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        buscar()
    })
    function buscar(){
        showTabListTemplateQueues('manage_template_queues')
    }
</script>