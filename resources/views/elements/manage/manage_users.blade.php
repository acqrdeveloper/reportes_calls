<input type="hidden" name="_token" value="{!! csrf_token() !!}">

<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">@yield('titleReport')</h3>
        <div class="box-tools">
            <input type="hidden" id="hidEvent" value="{{ $exportReport }}">
            <div class="btn-group pull-right">
                <a onclick="createUser();" class="btn btn-primary"><i class="fa fa-user-plus" aria-hidden="true"></i> Add User</a>
                @include('layout.recursos.buttons_export')
            </div>
        </div>
    </div>
    <div class="box-body">
        <table id="table-list-user" class="table table-bordered display nowrap table-responsive" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>First Name</th>
                    <th>Second Name</th>
                    <th>Last Name</th>
                    <th>Second Last Name</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Estado</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        buscar();
    })
    function buscar(){
        showTabListUser('manage_users')
    }
</script>