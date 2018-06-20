<!-- Modal -->
<div :class="ModalLoading" role="dialog" data-backdrop="static" data-keyboard="false" v-if="ModalLoading !== 'modal fade'">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="modal-title">Corporacion Sapia</h4>
      </div>
      <div class="modal-body">
        <div class="img-responsive ">
          <center>
        	<img src="{{ asset('img/cargando.gif') }}">
          </center>
        </div>
        <br>
      </div>
    </div>
  </div>
</div>
