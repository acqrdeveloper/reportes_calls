<div class="box box-primary">
    <div class="box-header">
        <div class="row">
            <div class="col-lg-6 col-">
                <h3 class="box-title">@yield('titleReport')</h3>
            </div>
            <div class="col-lg-6 text-right">
                <a class="btn btn-primary" onclick="responseModal('div.dialogAsterisk','form_create_cola_vip')" data-toggle="modal" data-target="#modalAsterisk">Agregar Nueva Cola Vip</a>
            </div>
        </div>
        <hr>
    </div>
    <div class="box-body">
        <table id="table-lista-vip" class="table table-bordered display nowrap table-responsive" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Nombre Cola Vip</th>
                <th>Numero Telefono</th>
                <th>Cola</th>
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
    showTabListVip('colas_lista_vip')
  }
</script>