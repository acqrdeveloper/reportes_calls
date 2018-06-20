<div class="row text-center" >
    <div class="col-xs-12">
        <div class="input-group">
            <div class="input-group-addon">
                <i class="fa fa-phone"></i>
            </div>
            <input type="text" class="form-control" id="search_annexed" placeholder="Ingrese el número de Anexo a buscar">
        </div>
    </div>
    <div class="col-xs-12">
        <div class="table-responsive">
            <table id="table-annexed" class="table table-bordered table-hover">
                <tbody>
                <?php $countArray = count($tabla_anexos); ?>
                @if($countArray > 0)
                    @foreach ($tabla_anexos as $key => $tabla_anexo)
                        <tr>
                            @foreach ($tabla_anexo as $key => $anexo)
                                <td>
                                    <a href="javascript:void(0)"  class='{{ $anexo['btn'] }}' @click="asignAnnexed">
                                        <a href="javascript:void(0)"  class='{{ $anexo['btn'] }}' onclick="assignAnexxed('{{ $anexo['name'] }}','{{$anexo['user']['id']}}','{{$anexo['user']['username']}}');" >
                                            <img class="img-responsive" width="74" height="74" name={{ $anexo['name'] }}  src={{ asset('img/'.$anexo['image']) }}  />
                                            <span class="text-black">
                                                Anexo {{ $anexo['name'] }}
                                                <br>
                                                @if($anexo['user']['id'] != '')
                                                    <span class="text-green">{{$anexo['user']['primer_nombre']}} {{$anexo['user']['apellido_paterno']}}</span>
                                                @else
                                                    <span class="text-green"> - </span>
                                                @endif
                                            </span>
                                        </a>
                                    </a>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>
                            <div class="alert alert-info">
                                <span>
                                    <i class="fa fa-warning"></i> No hay anexos asignados
                                </span>
                            </div>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    searchTable('#table-annexed','#search_annexed', 'td')
</script>