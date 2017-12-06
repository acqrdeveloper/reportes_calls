@include('layout.plugins.css-selectboostrap')
@include('layout.plugins.css-datepicker')
@include('layout.plugins.js-selectbootstrap')
@include('layout.plugins.js-datepicker')

<div class="box-header with-border">
    <i class="fa fa-filter"></i>
    <h3 class="box-title">Custom Filters</h3>
</div>
<table class="table table-bordered display nowrap table-responsive" cellspacing="0" width="100%">
    <tbody>
        <tr>
            @if($customDataFilter != '')
                <td>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </div>
                        <select class="show-tick show-menu-arrow" id="filter_fullname" data-live-search="true" data-width="100%" data-header="Buscar por Nombre Completo">
                            <option value="">Buscar por Nombre Completo</option>
                            @foreach($customDataFilter as $key => $customData)
                                <option value="{{ $customDataFilter[$key] }}">{{ $customDataFilter[$key] }}</option>
                            @endforeach
                        </select>
                    </div>
                </td>
            @endif
            <td>
                <div class="btn-group">
                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <button type="button" class="btn btn-success"><i class="fa fa-calendar-check-o"></i> Filter Date and Hour</button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a class="sortingDatatable" data-id="asc" href="javascript:void(0)">Ascending</a></li>
                        <li><a class="sortingDatatable" data-id="desc" href="javascript:void(0)">Descending</a></li>
                    </ul>
                </div>
            </td>
        </tr>
    </tbody>
</table>