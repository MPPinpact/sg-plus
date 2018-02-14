@php
$data = Session::get('perfiles');
$nroPerfiles = Session::get('nroPerfiles');
@endphp
<header class="main-header-top hidden-print">
  <a href="index.html" class="logo">
    <img class="img-fluid able-logo" src="/theme/assets/images/logo.png" alt="Theme-logo">
  </a>
  <nav class="navbar navbar-static-top">
    <a href="#!" data-toggle="offcanvas" class="sidebar-toggle hidden-md-up"></a>
    <div class="navbar-custom-menu">
      <ul class="top-nav">
        <li class="pc-rheader-submenu">
          <a href="#!" class="drop icon-circle" onclick="javascript:toggleFullScreen()">
            <i class="icon-size-fullscreen"></i>
          </a>
        </li>
        <li class="dropdown">
          <a href="#!" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle drop icon-circle drop-image">
            @php  
            $avatarUser = Auth::user()->usrUrlimage;
            (strlen($avatarUser) > 10) ? $avatar=$avatarUser : $avatar="img/default.jpg";
            @endphp
            <span>
              <img class="rounded-circle " src="{{ asset($avatar) }}" style="width:40px;" alt="User Image">
            </span>
            <span>
              @php echo Auth::user()->usrNombreFull; @endphp
              <i class=" icofont icofont-simple-down"></i>
            </span>
          </a>
          <ul class="dropdown-menu settings-menu">
            <li class="p-0">
              <div class="dropdown-divider m-0"></div>
            </li>
            <li><a href="#" id="btn-logout"><i class="icon-logout"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>