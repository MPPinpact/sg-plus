@php
$data = Session::get('perfiles');
$nroPerfiles = Session::get('nroPerfiles');
@endphp
<a href="/home" class="logo"><img class="img-fluid able-logo" src="/theme/assets/images/logo.png" alt="Theme-logo"></a>
<nav class="navbar navbar-static-top">
  <!-- Sidebar toggle button-->
  <a href="#!" data-toggle="offcanvas" class="sidebar-toggle hidden-md-up"></a>
  <!-- Navbar Right Menu-->
  <div class="navbar-custom-menu">
    <ul class="top-nav">
      <!--Notification Menu-->
      <li class="dropdown pc-rheader-submenu message-notification search-toggle">
         <!-- <a href="#!" id="morphsearch-search" class="drop icon-circle txt-white"> -->
          <!-- <i class="icofont icofont-search-alt-1"></i> -->
        <!-- </a> -->
      </li>
      <li class="dropdown notification-menu">
        <a href="#!" data-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
          <i class="icon-bell"></i>
          <span class="badge badge-danger header-badge">9</span>
        </a>
      </li>
      <!-- chat dropdown -->
      <li class="pc-rheader-submenu ">
        <a href="#!" class="drop icon-circle displayChatbox">
          <i class="icon-bubbles"></i>
          <span class="badge badge-danger header-badge blink">5</span>
        </a>
      </li>
      <!-- window screen -->
      <li class="pc-rheader-submenu">
        <a href="#!" class="drop icon-circle" onclick="javascript:toggleFullScreen()">
          <i class="icon-size-fullscreen"></i>
        </a>
      </li>
      <!-- User Menu-->
      <li class="dropdown">
        <a href="#!" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle drop icon-circle drop-image">
              @php  
                $avatarUser = Auth::user()->usrUrlimage;
                (strlen($avatarUser) > 10) ? $avatar=$avatarUser : $avatar="img/default.jpg";
              @endphp
          <span><img class="rounded-circle " src="{{ asset($avatar) }}" style="width:40px;" alt="User Image"></span>
           @if (isset($data))
              @if (strlen($data['v_detalle'][0]->usrNombreFull)>1)
                <span>
                  {{$data['v_detalle'][0]->usrNombreFull}}
                  <i class=" icofont icofont-simple-down"></i>
                </span>
              @endif
            @endif
        </a>
        <ul class="dropdown-menu settings-menu">
          <li><a href="{{ route('perfil') }}"><i class="icon-user"></i> Mi perfíl</a></li>
          <li><a href="{{ route('password') }}"><i class="icon-reload"></i>Cambiar contraseña</a></li>
          @if (isset($nroPerfiles))
            @if ($nroPerfiles>1)
              <li><a href="{{ route('accesos') }}"><i class="icon-shuffle"></i>Cambio de Acceso</a></li>
            @endif
          @endif
          <li class="p-0">
            <div class="dropdown-divider m-0"></div>
          </li>
          <li><a href="#" id="btn-logout"><i class="icon-logout"></i> Logout</a></li>
        </ul>
      </li>
    </ul>
    <!-- search -->
    <div id="morphsearch" class="morphsearch">
      <form class="morphsearch-form">
        <input class="morphsearch-input" type="search" placeholder="Search..."/>
        <button class="morphsearch-submit" type="submit">Search</button>
      </form>
      <div class="morphsearch-content"></div>
    </div>
    <!-- search end -->
  </div>
</nav>