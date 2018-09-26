<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">@yield('titleReport')</h3>
    </div>
    <div class="box-body">
        <table id="table-list-encoladas" class="table table-bordered display nowrap table-responsive" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Nombre Colas</th>
                <th>Nombre Numero</th>
                <th>Telefono</th>
                <th>Duracion</th>
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
      showTabListEncoladas('manage_encoladas')
    }
</script>