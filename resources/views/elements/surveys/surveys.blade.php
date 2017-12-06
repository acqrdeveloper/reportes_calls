<div class="panel panel-default">
    <ul class="nav nav-tabs nav-pills ">
        <li role="tab" class="active">
            <a href="#panel-active" role="tab" data-toggle="tab" onclick="showTabSurveys('surveys_inbound')">
                <icon class="glyphicon glyphicon-random"></icon>Inbound
            </a>
        </li>
        <li role="tab">
            <a href="#panel-report" role="tab" data-toggle="tab" onclick="showTabSurveys('surveys_outbound')">
                <icon class="glyphicon glyphicon-alert"></icon>Outbound
            </a>
        </li>
        <li role="tab">
            <a href="#panel-report" role="tab" data-toggle="tab" onclick="showTabSurveys('surveys_released')">
                <icon class="glyphicon glyphicon-earphone"></icon>Released
            </a>
        </li>
    </ul>
    <input type="hidden" id="hidDefaultEvent" value="calls_completed">
    <div class="panel-body" >
        <div class="tab-pane fade active in" id="panel-report">
            <table id="table-surveys" class="table table-bordered display nowrap table-responsive" cellspacing="0" width="100%">
                <thead>                
                    <tr>
                        <th>Type Survey</th>
                        <th>Date</th>
                        <th>Hour</th>
                        <th>Fecha Hora</th>
                        <th>Username</th>
                        <th>Anexo</th>
                        <th>Telephone</th>
                        <th>Skill</th>
                        <th>Duration</th>
                        <th>Question_01</th>
                        <th>Answer_01</th>
                        <th>Question_02</th>
                        <th>Answer_02</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        surveys()
    })

    filterDateHourDatatable('#table-surveys',3)

    function surveys(){
        showTabSurveys('surveys_inbound')
        DataTableHide(false,'table-surveys',[3])
    }
</script>