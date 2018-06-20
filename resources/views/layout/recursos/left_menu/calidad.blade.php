<li class="treeview">
    <a href="javascript:void(0)">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li><a href="dashboard_01" target="_blank"><i class="fa fa-circle-o text-red"></i> Dashboard 01</a></li>
        <!--<li><a href="#" v-on:click="loadOptionMenu('dashboard_03')"> <i class="fa fa-circle-o text-blue"></i> Dashboard 03</a></li>-->
    </ul>
</li>

<li class="treeview">
    <a href="javascript:void(0)">
        <i class="fa fa-calendar-check-o"></i> <span>Reporting Events</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li><a href="#" v-on:click="loadOptionMenu('events_detail')" class="reportes"><i class="fa fa-circle-o text-purple"></i> Detail Events</a></li>
        <li><a href="#" v-on:click="loadOptionMenu('detail_event_report')"  class="reportes"><i class="fa fa-circle-o text-fuchsia"></i> Level Of Occupation</a></li>
    </ul>
</li>

<li class="treeview">
    <a href="#">
        <i class="fa fa-phone-square"></i> <span>Reporting Calls</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li><a href="#" v-on:click="loadOptionMenu('agents_online')"> <i class="fa fa-circle-o text-red"></i> Agents Online</a></li>
        <li><a href="#" v-on:click="loadOptionMenu('incoming_calls')"> <i class="fa fa-circle-o text-green"></i> Inbound Calls</a></li>
        <li><a href="#" v-on:click="loadOptionMenu('outgoing_calls')"> <i class="fa fa-circle-o text-yellow"></i> Outbound Calls</a></li>
        <li><a href="#" v-on:click="loadOptionMenu('consolidated_calls')"> <i class="fa fa-circle-o text-blue"></i> Consolidated Calls</a></li>
    </ul>
</li>

<li class="treeview">
    <a href="#">
        <i class="fa fa-book"></i> <span>Reporting Surveys</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li><a href="#" v-on:click="loadOptionMenu('surveys')"><i class="fa fa-circle-o text-purple"></i> Detail Surveys</a></li>
    </ul>
</li>

<li class="treeview active">
    <a href="#">
        <i class="fa fa-gears"></i> <span>Administrator</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li><a href="#" v-on:click="loadOptionMenu('agents_annexed')"> <i class="fa fa-circle-o text-purple"></i> Assign Annexed</a></li>
        <!--<li><a href="#" v-on:click="loadOptionMenu('broadcast_message')"> <i class="fa fa-circle-o text-green"></i> BroadCast Message</a></li>-->
    </ul>
</li>
