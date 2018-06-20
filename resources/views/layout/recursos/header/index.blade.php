<header class="main-header">
    <a href="/" class="logo">
        <span class="logo-mini">{{getenv('PROYECT_NAME_SHORT')}}</span>
        <span class="logo-lg">{{getenv('PROYECT_NAME_COMPLETE')}}</span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation" id="menuHeader">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              @include('layout.recursos.header.release_from_extension')
              {{-- @include('layout.recursos.header.message') --}}
              {{-- @include('layout.recursos.header.notification') --}}
              @include('layout.recursos.header.view_queues')
              @include('layout.recursos.header.profile_user')
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
              <!-- Button para Cambiar Contraseña -->
              <button id="changePassword" type="button" class="hidden" onclick="responseModal('div.dialogUsers','form_change_password',vueFront.getUserId)" data-toggle="modal" data-target="#modalUsers"></button>
            </ul>
        </div>
    </nav>
</header>
