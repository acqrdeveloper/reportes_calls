    <div class="box box-primary">
        <div class="box-body">
            <div class="box-tools">
                <button type="button" class="btn btn-info pull-right" data-toggle="modal"
                        data-target="#modalDetailsEvents"><i class="fa fa-eercast"></i> Leyenda
                </button>
                <br>
            </div>
            <br>
            <table id="table-level" class="table table-bordered display nowrap table-responsive" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>User</th>
                    <th>Rango</th>
                    <th style='background-color: yellow'>Tiempo Diff Inicial</th>
                    <th>Disponible</th>
                    <th>Break</th>
                    <th>SSHH</th>
                    <th>Refrigerio</th>
                    <th>Feedback</th>
                    <th>Capacitacion</th>
                    <th>Gestion BackOffice</th>
                    <th>Inbound</th>
                    <th>OutBound</th>
                    <th>Ring Inbound</th>
                    <th>Ring Outbound</th>
                    <th>Hold Inbound</th>
                    <th>Hold Outbound</th>
                    <th>Ring Inbound Interno</th>
                    <th>Inbound Interno</th>
                    <th>Outbound Interno</th>
                    <th>Ring Outbound Interno</th>
                    <th>Hold Inbound Interno</th>
                    <th>Hold Outbound Interno</th>
                    <th>Ring Inbound Transfer</th>
                    <th>Inbound Transfer</th>
                    <th>Hold Inbound Transfer</th>
                    <th>Ring Outbound Transfer</th>
                    <th>Hold Outbound Transfer</th>
                    <th>Outbound Transfer</th>
                    <th>Desconectado</th>
                    <th style='background-color: red'>Tiempo Diff Final</th>
                    <th>Total</th>
                    <th>Nivel Ocupacion</th>
                    <th>Nivel Ocupacion Backoffice</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    <script type="text/javascript">

        $(document).ready(function(){
            buscar();
        });

        function buscar(){
                $("#table-level").dataTable().fnDestroy();
                $("#table-level").DataTable({
                    "ajax"              : {
                        url     : "report_level",
                        type    : "POST",
                        dataSrc : "data",
                        data :{
                            _token       : $('meta[name="_token"]').attr('content'),
                            filter_rol   : $('select[name=rolUser]').val(),
                            group_filter : $('select[name=groupFilter]').val(),
                            fecha_evento : $("input[name=fecha_evento]").val()
                        }
                    },
                    "columns"    : [
                        {'data': 'User','order': 'asc'},
                        {'data': 'Rango'},
                        {'data': 'Tiempo Diff Inicial'},
                        {'data': 'Disponible'},
                        {'data': 'Break'},
                        {'data': 'SSHH'},
                        {'data': 'Refrigerio'},
                        {'data': 'Feedback'},
                        {'data': 'Capacitacion'},
                        {'data': 'Gestion BackOffice'},
                        {'data': 'Inbound'},
                        {'data': 'OutBound'},
                        {'data': 'Ring Inbound'},
                        {'data': 'Ring Outbound'},
                        {'data': 'Hold Inbound'},
                        {'data': 'Hold Outbound'},
                        {'data': 'Ring Inbound Interno'},
                        {'data': 'Inbound Interno'},
                        {'data': 'Outbound Interno'},
                        {'data': 'Ring Outbound Interno'},
                        {'data': 'Hold Inbound Interno'},
                        {'data': 'Hold Outbound Interno'},
                        {'data': 'Ring Inbound Transfer'},
                        {'data': 'Inbound Transfer'},
                        {'data': 'Hold Inbound Transfer'},
                        {'data': 'Ring Outbound Transfer'},
                        {'data': 'Hold Outbound Transfer'},
                        {'data': 'Outbound Transfer'},
                        {'data': 'Desconectado'},
                        {'data': 'Tiempo Diff Final'},
                        {'data': 'Total'},
                        {'data': 'Nivel Ocupacion'},
                        {'data': 'Nivel Ocupacion Backoffice'},

                    ],
                    "paging"            : true,
                    "pageLength"        : 100,
                    "lengthMenu"        : [100, 200, 300, 400, 500],
                    "scrollY"           : "300px",
                    "scrollX"           : true,
                    "scrollCollapse"    : true,
                    "select"            : true,
                    fixedColumns        : false
                });
                // $("#table-level-2").DataTable({
                //     "ajax"              : {
                //         url     : "report_level",
                //         type    : "POST",
                //         dataSrc : "data",
                //         data :{
                //             _token       : $('meta[name="_token"]').attr('content'),
                //             filter_rol   : $('select[name=rolUser]').val(),
                //             group_filter : $('select[name=groupFilter]').val(),
                //             fecha_evento : $("input[name=fecha_evento]").val()
                //         }
                //     },
                //     "columns"    : [
                //         {'data': 'User', 'order': 'asc'},
                //         {'data': 'Rango', 'order': 'asc'},
                //         {'data': 'Tiempo Diff Inicial'},
                //         {'data': 'Disponible'},
                //         {'data': 'Break'},
                //         {'data': 'SSHH'},
                //         {'data': 'Refrigerio'},
                //         {'data': 'Feedback'},
                //         {'data': 'Capacitacion'},
                //         {'data': 'Gestion BackOffice'},
                //         {'data': 'Inbound'},
                //         {'data': 'OutBound'},
                //         {'data': 'Ring Inbound'},
                //         {'data': 'Ring Outbound'},
                //         {'data': 'Hold Inbound'},
                //         {'data': 'Hold Outbound'},
                //         {'data': 'Ring Inbound Interno'},
                //         {'data': 'Inbound Interno'},
                //         {'data': 'Outbound Interno'},
                //         {'data': 'Ring Outbound Interno'},
                //         {'data': 'Hold Inbound Interno'},
                //         {'data': 'Hold Outbound Interno'},
                //         {'data': 'Ring Inbound Transfer'},
                //         {'data': 'Inbound Transfer'},
                //         {'data': 'Hold Inbound Transfer'},
                //         {'data': 'Ring Outbound Transfer'},
                //         {'data': 'Hold Outbound Transfer'},
                //         {'data': 'Outbound Transfer'},
                //         {'data': 'Desconectado'},
                //         {'data': 'Tiempo Diff Final'},
                //         {'data': 'Total'}
                //     ],
                //     "paging"            : true,
                //     "pageLength"        : 100,
                //     "lengthMenu"        : [100, 200, 300, 400, 500],
                //     "scrollY"           : "300px",
                //     "scrollX"           : true,
                //     "scrollCollapse"    : true,
                //     "select"            : true,
                //     fixedColumns        : true
                // });

        }

    </script>