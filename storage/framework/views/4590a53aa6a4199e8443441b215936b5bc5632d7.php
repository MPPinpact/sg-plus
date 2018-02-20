<?php
$data = Session::get('perfiles');
$nroPerfiles = Session::get('nroPerfiles');
?>
<header class="main-header-top hidden-print">
  <a href="/home" class="logo">
    <img class="img-fluid able-logo" src="/theme/assets/images/logo.png" alt="Theme-logo">
  </a>
  <nav class="navbar navbar-static-top">
    <a href="#!" data-toggle="offcanvas" class="sidebar-toggle hidden-md-up"></a>
    <div class="navbar-custom-menu">
      <div class="row">
        <div class="col-md-12">
          <ul class="top-nav">
            <li class="dropdown notification-menu">
              <a href="#!" data-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                <i class="icon-bell"></i>
                <span class="badge badge-danger header-badge">9</span>
              </a>
              <ul class="dropdown-menu">
                <li class="not-head">You have <b class="text-primary">4</b> new notifications.</li>
                <li class="bell-notification">
                  <a href="javascript:;" class="media">
                    <span class="mr-3 media-icon"> 
                      <img class="rounded-circle" src="<?php echo e(asset('theme/assets/images/avatar-1.png')); ?>" alt="User Image">
                    </span>
                    <div class="media-body"><span class="block">Lisa sent you a mail</span><span class="text-muted block-time">2min ago</span></div></a>
                  </li>
                  <li class="bell-notification">
                    <a href="javascript:;" class="media">
                      <span class="mr-3 media-icon">  
                        <img class="rounded-circle" src="<?php echo e(asset('theme/assets/images/avatar-2.png')); ?>" alt="User Image">
                      </span>
                      <div class="media-body"><span class="block">Server Not Working</span><span class="text-muted block-time">20min ago</span></div></a>
                    </li>
                    <li class="bell-notification">
                      <a href="javascript:;" class="media"><span class="mr-3 media-icon">
                        <img class="rounded-circle" src="<?php echo e(asset('theme/assets/images/avatar-3.png')); ?>" alt="User Image">
                      </span>
                      <div class="media-body"><span class="block">Transaction xyz complete</span><span class="text-muted block-time">3 hours ago</span></div></a>
                    </li>
                    <li class="not-footer">
                      <a href="#!">See all notifications.</a>
                    </li>
                  </ul>
                </li>
                <li class="pc-rheader-submenu">
                  <a href="#!" class="drop icon-circle" onclick="javascript:toggleFullScreen()">
                    <i class="icon-size-fullscreen"></i>
                  </a>
                </li>
                <li class="dropdown">
                  <a href="#!" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle drop icon-circle drop-image">
                    <?php  
                    $avatarUser = Auth::user()->usrUrlimage;
                    (strlen($avatarUser) > 10) ? $avatar=$avatarUser : $avatar="img/default.jpg";
                    ?>
                    <span><img class="rounded-circle avatar" src="<?php echo e(asset($avatar)); ?>" alt=""></span>
                    <?php if(isset($data)): ?>
                    <?php if(strlen($data['v_detalle'][0]->usrNombreFull)>1): ?>
                    <span>
                      <?php echo e($data['v_detalle'][0]->usrNombreFull); ?>

                      <i class=" icofont icofont-simple-down"></i>
                    </span>
                    <?php endif; ?>
                    <?php endif; ?>
                  </a>
                  <ul class="dropdown-menu settings-menu">
                    <li><a href="<?php echo e(route('perfil')); ?>"><i class="icon-user"></i> Mi perfíl</a></li>
                    <li><a href="<?php echo e(route('password')); ?>"><i class="icon-reload"></i>Cambiar contraseña</a></li>
                    <?php if(isset($nroPerfiles)): ?>
                    <?php if($nroPerfiles>1): ?>
                    <li><a href="<?php echo e(route('accesos')); ?>"><i class="icon-shuffle"></i>Cambio de Acceso</a></li>
                    <?php endif; ?>
                    <?php endif; ?>
                    <li class="p-0">
                      <div class="dropdown-divider m-0"></div>
                    </li>
                    <li><a href="#" id="btn-logout"><i class="icon-logout"></i> Logout</a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
    </header>