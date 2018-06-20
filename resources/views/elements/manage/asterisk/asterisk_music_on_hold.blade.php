<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">@yield('titleReport')</h3>
    </div>
    <div class="box-body">
        <table id="table-list-music-on-hold" class="table table-bordered display nowrap table-responsive" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Id</th>
                <th>Name Music</th>
                <th>Mode Music</th>
                <th>Status</th>
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
        showTabListMusicOnHold('manage_music_on_hold')
    }
</script>