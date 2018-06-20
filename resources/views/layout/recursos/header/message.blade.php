<li class="dropdown messages-menu">
 <a href="#" class="dropdown-toggle" data-toggle="dropdown">
   <i class="fa fa-envelope-o"></i>
   <span class="label label-success" v-text="getBroadcastMessage.length"></span>
 </a>
 <ul class="dropdown-menu">
   <li class="header">You have @{{ getBroadcastMessage.length }} messages</li>
   <li>
     <ul class="menu">
       <li v-for="(broadcastMessage, index) in getBroadcastMessage">
         <a href="#" style="cursor:pointer;">
           <div class="pull-left">
             <img src="storage/default_avatar.png" class="img-circle" alt="User Image">
           </div>
           <h4>
              @{{ broadcastMessage['nombrePublicador'] }}
             <small><i class="fa fa-clock-o"></i> 5 mins</small>
           </h4>
           <p>@{{ broadcastMessage['message'] }}</p>
         </a>
       </li>
      </ul>
   </li>
   <li class="footer"><a href="#">See All Messages</a></li>
 </ul>
</li>
