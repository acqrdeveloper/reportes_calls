@if($viewButtonSearch)
    @include('layout.recursos.buttons_search', ['classButton' => 'hidden-lg'])
@endif
<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
</button>
<button type="button" class="btn btn-success"><i class="fa fa-calendar-check-o"></i> Filter Date and Hour</button>
<ul class="dropdown-menu" role="menu">
    <li><a class="sortingDatatable" data-id="asc" href="javascript:void(0)">Ascending</a></li>
    <li><a class="sortingDatatable" data-id="desc" href="javascript:void(0)">Descending</a></li>
</ul>
<a onclick="exportar('csv')" class="btn btn-instagram"><span class="fa fa-file-code-o" aria-hidden="true"></span> Export Csv</a>
<a onclick="exportar('excel')" class="btn btn-success"><span class="fa fa-file-excel-o" aria-hidden="true"></span> Export Excel</a>
