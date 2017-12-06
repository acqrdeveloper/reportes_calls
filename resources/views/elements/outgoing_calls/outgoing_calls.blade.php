<div class="panel panel-default">
    <div class="panel-body" >
        <div class="tab-pane fade active in" id="panel-report">
            <table id="table-outgoing" class="table table-bordered display nowrap table-responsive" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Hour</th>
                    <th>Fecha Hora</th>
                    <th>Annexed Origin</th>
                    <th>Username</th>
                    <th>Number Destination</th>
                    <th>Call Time</th>
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
        buscar()
    })

    filterDateHourDatatable('#table-outgoing',2)

    function buscar(){
        showTabOutgoing('outgoing_calls');
        DataTableHide(true,'table-outgoing',[6,7],'{{Session::get('UserRole')}}')
        DataTableHide(false,'table-outgoing',[2])
    }
</script>

