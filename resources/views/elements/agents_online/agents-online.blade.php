<input type="hidden" name="_token" value="{!! csrf_token() !!}">

<div class="panel panel-default">
    <div class="panel-body" >
        <div class="tab-pane fade active in" id="panel-report">
            <table id="table-agentOnline" class="table table-bordered display nowrap table-responsive" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Hour</th>
                    <th>Fecha Hora</th>
                    <th>Agents</th>
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

    filterDateHourDatatable('#table-agentOnline',2)

    function buscar(){
        showTabAgentOnline('agents_online')
        DataTableHide(false,'table-agentOnline',[2])
    }
</script>