<div class="box box-primary">
    <div class="box-header">
        <div class="row">
            <div class="col-lg-6 col-">
                <h3 class="box-title">@yield('titleReport')</h3>
            </div>
            <div class="col-lg-6 text-right">
                <a class="btn btn-primary" onclick="responseModal('div.dialogAsterisk','form_create_sound_massive')" data-toggle="modal" data-target="#modalAsterisk">Agregar Nuevo</a>
            </div>
        </div>
        <hr>
    </div>
    <div class="box-body">
        <table id="table-list-sound-massive" class="table table-bordered display nowrap table-responsive" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Estado IVR</th>
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
    showTabListSoundMassive('manage_sound_massive')
  }
</script>