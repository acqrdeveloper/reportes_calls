<div class="panel panel-default">
    <ul class="nav nav-tabs nav-pills ">
        <li role="tab" class="active">
            <a href="#panel-report" role="tab" data-toggle="tab" onclick="showTabIncoming('calls_completed')">
                <icon class="glyphicon glyphicon-earphone"></icon>Atendidas
            </a>
        </li>
        <li role="tab">
            <a href="#panel-report" role="tab" data-toggle="tab" onclick="showTabIncoming('calls_transfer')">
                <icon class="glyphicon glyphicon-random"></icon>Transferidas
            </a>
        </li>
        <li role="tab">
            <a href="#panel-report" role="tab" data-toggle="tab" onclick="showTabIncoming('calls_abandone')">
                <icon class="glyphicon glyphicon-alert"></icon>Abandonadas
            </a>
        </li>
    </ul>
    <input type="hidden" id="hidDefaultEvent" value="calls_completed">
    <div class="panel-body" >
        <div class="tab-pane fade active in" id="panel-report">
            <table id="table-incoming" class="table table-bordered display nowrap table-responsive" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Hour</th>
                    <th>Fecha Hora</th>
                    <th>Telephone</th>
                    <th>Agent</th>
                    <th>Skill</th>
                    <th>Duration</th>
                    <th>Action</th>
                    <th>Wait Time</th>
                    <th><i class="fa fa-download"   aria-hidden="true"></i> Download</th>
                    <th><i class="fa fa-play"       aria-hidden="true"></i> Listen</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    showTabIncoming('calls_completed')
    DataTableHide(true,'table-incoming',[8,9],'{{Session::get('UserRole')}}')
    DataTableHide(false,'table-incoming',[2])
})

filterDateHourDatatable('#table-incoming',2)

$('.nav-tabs > li').click(function() {
    DataTableHide(true,'table-incoming',[8,9],'{{Session::get('UserRole')}}')
    DataTableHide(false,'table-incoming',[2])
})
</script>
