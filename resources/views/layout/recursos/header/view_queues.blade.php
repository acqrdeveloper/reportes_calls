<li class="dropdown tasks-menu">

  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-phone"></i>
    <span class="label label-info" v-text="getQueuesUser.length"></span>
  </a>
  
  <ul class="dropdown-menu">
    <li class="header text-center text-bold">You have @{{ getQueuesUser.length }} queues</li>
    <li>
      <ul class="menu">
        <li v-for="(queuesUser, index) in getQueuesUser">
          <a style="cursor:pointer;">
            <h3>
                @{{ queuesUser['Queues']['name'] }}
                <small class="pull-right" v-text="getPercentageOfWeightQueue[index] + ' %'"></small>
            </h3>
            <div class="progress xs">
                <div :class="[ 'progress-bar progress-bar-' + getColorPercentageOfWeightQueue[index] ]" :style="{ width: getPercentageOfWeightQueue[index] + '%' }" role="progressbar"
                     aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    <span class="sr-only" v-text="getPercentageOfWeightQueue[index] + '% de Recibir Llamadas'"></span>
                </div>
            </div>
          </a>
        </li>
      </ul>
    </li>
  </ul>
</li>
