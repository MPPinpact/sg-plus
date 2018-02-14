<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <?php
      header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
      header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
      header("Cache-Control: no-store, no-cache, must-revalidate");
      header("Cache-Control: post-check=0, pre-check=0", false);
      header("Pragma: no-cache");
  ?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <link rel="shortcut icon" href="{{ asset('theme/assets/images/favicon.png') }}" type="image/x-icon">
  <link rel="icon" href="{{ asset('theme/assets/images/favicon.ico') }}" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script language="JavaScript" type="text/javascript">
      var v_salir = 0;
      var RutaSalir = "{{ URL::route('logout') }}";
      var salir = "{{ URL::route('logout') }}";
      var v = [];
      v['v_perfil'] = '';
      v['idUser'] = '';
  </script>
  {!! Html::style('theme/assets/icon/icofont/css/icofont.css') !!}
  {!! Html::style('theme/assets/icon/simple-line-icons/css/simple-line-icons.css') !!}
  {!! Html::style('theme/bower_components/bootstrap/css/bootstrap.min.css') !!}
  {!! Html::style('theme/bower_components/chartist/css/chartist.css') !!}
  {!! Html::style('theme/assets/css/svg-weather.css') !!}
  {!! Html::style('theme/assets/css/main.css') !!}
  {!! Html::style('theme/assets/css/responsive.css') !!}
  <link rel="stylesheet" type="text/css" href="{{ asset('theme/assets/css/color/color-1.css') }}" id="color"/>
  {!! Html::style('theme/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css') !!}
  {!! Html::style('theme/assets/plugins/data-table/css/buttons.dataTables.min.css') !!}
  {!! Html::style('theme/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') !!}
  {!! Html::style('theme/bower_components/datatables.net/css/select.bootstrap4.css') !!}

  {!! Html::style('theme/assets/plugins/list-scroll/css/list.css') !!}
  {!! Html::style('theme/bower_components/stroll/css/stroll.css') !!}

  {!! Html::style('plugins/validator/formValidation.min.css') !!}
  {!! Html::style('theme/bower_components/select2/css/select2.min.css') !!}
  {!! Html::style('plugins/jQuery-contextMenu-master/dist/jquery.contextMenu.min.css') !!}
  {!! Html::style('css/login/login.css') !!}
  <!-- JS -->
  {{ HTML::script('theme/bower_components/jquery/js/jquery.min.js') }}
  {{ HTML::script('theme/bower_components/jquery-ui/js/jquery-ui.min.js') }}
  {{ HTML::script('theme/bower_components/popper.js/js/popper.min.js') }}
  {{ HTML::script('theme/bower_components/bootstrap/js/bootstrap.min.js') }}
  {{ HTML::script('theme/assets/plugins/waves/js/waves.min.js') }}
  {{ HTML::script('theme/bower_components/jquery-slimscroll/js/jquery.slimscroll.js') }}
  {{ HTML::script('theme/assets/plugins/jquery.nicescroll/js/jquery.nicescroll.min.js') }}
  {{ HTML::script('theme/bower_components/classie/js/classie.js') }}
  {{ HTML::script('theme/assets/plugins/notification/js/bootstrap-growl.min.js') }}
  {{ HTML::script('theme/bower_components/jquery-sparkline/js/jquery.sparkline.js') }}
  {{ HTML::script('theme/bower_components/waypoints/js/jquery.waypoints.min.js') }}
  {{ HTML::script('theme/assets/plugins/countdown/js/jquery.counterup.js') }}
  {{ HTML::script('theme/assets/js/main.min.js') }}
  {{ HTML::script('theme/assets/pages/elements.js') }}
  {{ HTML::script('theme/assets/js/menu-horizontal.min.js') }}
  {{ HTML::script('plugins/validator/formValidation.min.js') }}
  {{ HTML::script('plugins/validator/fvbootstrap.min.js') }}
  {{ HTML::script('plugins/validator/es_ES.min.js') }}
  {{ HTML::script('theme/bower_components/select2/js/select2.full.min.js') }}
  {{ HTML::script('theme/bower_components/datatables.net/js/jquery.dataTables.min.js') }}
  {{ HTML::script('theme/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}
  {{ HTML::script('theme/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js') }}
  {{ HTML::script('theme/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js') }}
  {{ HTML::script('theme/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}


  {{ HTML::script('theme/assets/pages/contact-detail.js') }}
  {{ HTML::script('theme/bower_components/stroll/js/stroll.js') }}
  {{ HTML::script('theme/assets/plugins/list/js/list.js') }}
 


  {{ HTML::script('theme/bower_components/datatables.net/js/dataTables.select.js') }}
  {{ HTML::script('theme/assets/plugins/data-table/js/jszip.min.js') }}
  {{ HTML::script('theme/assets/plugins/data-table/js/pdfmake.min.js') }}
  {{ HTML::script('theme/assets/plugins/data-table/js/vfs_fonts.js') }}
  {{ HTML::script('theme/bower_components/datatables.net-buttons/js/buttons.print.min.js') }}
  {{ HTML::script('theme/bower_components/datatables.net-buttons/js/buttons.html5.min.js') }}
  {{ HTML::script('plugins/jQuery-contextMenu-master/dist/jquery.contextMenu.min.js') }}
  {{ HTML::script('plugins/validator/valtexto.js') }}
  {{ HTML::script('js/utils/utils.js') }}
  {{ HTML::script('js/index/index.js') }}
</head>
<body onLoad="if ('Navigator' == navigator.appName)document.forms[0].reset();" class="horizontal-fixed fixed">
  <form id="formLogout" method="POST" style="display: none;">
    {{ csrf_field() }}
  </form>
  <div class="wrapper">
    <div class="loader-bg">
      <div class="loader-bar">
      </div>
    </div>
    <!-- Navbar-->
    @include('menu.menu_navbar')
    <!-- Side-Nav-->
    @include('menu.menu_aside')
    <!-- Sidebar chat start -->
    <div id="sidebar" class="p-fixed header-users showChat">
      <div class="had-container">
        <div class="card card_main header-users-main">
          <div class="card-content user-box">

            <div class="md-group-add-on p-20">
              <span class="md-add-on">
                <i class="icofont icofont-search-alt-2 chat-search"></i>
              </span>
              <div class="md-input-wrapper">
                <input type="text" class="md-form-control"  name="username" id="search-friends">
                <label for="username">Search</label>
              </div>

            </div>
            <div class="media friendlist-main">

              <h6>Friend List</h6>

            </div>
            <div class="main-friend-list">
              <div class="media friendlist-box" data-id="1" data-status="online" data-username="Josephin Doe" data-toggle="tooltip" data-placement="left" title="Josephin Doe">

                <a class="mr-3" href="#!">
                  <img class="media-object rounded-circle" src="{{ asset('theme/assets/images/avatar-1.png') }}" alt="Generic placeholder image">
                  <div class="live-status bg-success"></div>
                </a>
                <div class="media-body">
                  <div class="friend-header">Josephin Doe</div>
                  <span>20min ago</span>
                </div>
              </div>
              <div class="media friendlist-box" data-id="3" data-status="online" data-username="Alice"  data-toggle="tooltip" data-placement="left" title="Alice">
                <a class="mr-3" href="#!">
                  <img class="media-object rounded-circle" src="{{ asset('theme/assets/images/avatar-2.png') }}" alt="Generic placeholder image">
                  <div class="live-status bg-success"></div>
                </a>
                <div class="media-body">
                  <div class="friend-header">Alice</div>
                  <span>1 hour ago</span>
                </div>
              </div>
              <div class="media friendlist-box" data-id="7" data-status="offline" data-username="Michael Scofield" data-toggle="tooltip" data-placement="left" title="Michael Scofield">
                <a class="mr-3" href="#!">
                  <img class="media-object rounded-circle" src="{{ asset('theme/assets/images/avatar-3.png') }}" alt="Generic placeholder image">
                  <div class="live-status bg-danger"></div>
                </a>
                <div class="media-body">
                  <div class="friend-header">Michael Scofield</div>
                  <span>3 hours ago</span>
                </div>
              </div>
              <div class="media friendlist-box" data-id="5" data-status="online" data-username="Irina Shayk" data-toggle="tooltip" data-placement="left" title="Irina Shayk">
                <a class="mr-3" href="#!">
                  <img class="media-object rounded-circle" src="{{ asset('theme/assets/images/avatar-4.png') }}" alt="Generic placeholder image">
                  <div class="live-status bg-success"></div>
                </a>
                <div class="media-body">
                  <div class="friend-header">Irina Shayk</div>
                  <span>1 day ago</span>
                </div>
              </div>
              <div class="media friendlist-box" data-id="6" data-status="offline" data-username="Sara Tancredi" data-toggle="tooltip" data-placement="left" title="Sara Tancredi">
                <a class="mr-3" href="#!">
                  <img class="media-object rounded-circle" src="{{ asset('theme/assets/images/avatar-5.png') }}" alt="Generic placeholder image">
                  <div class="live-status bg-danger"></div>
                </a>
                <div class="media-body">
                  <div class="friend-header">Sara Tancredi</div>
                  <span>2 days ago</span>
                </div>
              </div>
              <div class="media friendlist-box" data-id="1" data-status="online" data-username="Josephin Doe" data-toggle="tooltip" data-placement="left" title="Josephin Doe">
                <a class="mr-3" href="#!">
                  <img class="media-object rounded-circle" src="{{ asset('theme/assets/images/avatar-2.png') }}" alt="Generic placeholder image">
                  <div class="live-status bg-success"></div>
                </a>
                <div class="media-body">
                  <div class="friend-header">Josephin Doe</div>
                  <span>20min ago</span>
                </div>
              </div>
              <div class="media friendlist-box" data-id="3" data-status="online" data-username="Alice" data-toggle="tooltip" data-placement="left" title="Alice">
                <a class="mr-3" href="#!">
                  <img class="media-object rounded-circle" src="{{ asset('theme/assets/images/avatar-2.png') }}" alt="Generic placeholder image">
                  <div class="live-status bg-success"></div>
                </a>
                <div class="media-body">
                  <div class="friend-header">Alice</div>
                  <span>1 hour ago</span>
                </div>
              </div>
              <div class="media friendlist-box" data-id="1" data-status="online" data-username="Josephin Doe" data-toggle="tooltip" data-placement="left" title="Josephin Doe">

                <a class="mr-3" href="#!">
                  <img class="media-object rounded-circle" src="{{ asset('theme/assets/images/avatar-1.png') }}" alt="Generic placeholder image">
                  <div class="live-status bg-success"></div>
                </a>
                <div class="media-body">
                  <div class="friend-header">Josephin Doe</div>
                  <span>20min ago</span>
                </div>
              </div>
              <div class="media friendlist-box" data-id="3" data-status="online" data-username="Alice" data-toggle="tooltip" data-placement="left" title="Alice">
                <a class="mr-3" href="#!">
                  <img class="media-object rounded-circle" src="{{ asset('theme/assets/images/avatar-2.png') }}" alt="Generic placeholder image">
                  <div class="live-status bg-success"></div>
                </a>
                <div class="media-body">
                  <div class="friend-header">Alice</div>
                  <span>1 hour ago</span>
                </div>
              </div>
              <div class="media friendlist-box" data-id="1" data-status="online" data-username="Josephin Doe" data-toggle="tooltip"  data-placement="left" title="Josephin Doe">

                <a class="mr-3" href="#!">
                  <img class="media-object rounded-circle" src="{{ asset('theme/assets/images/avatar-1.png') }}" alt="Generic placeholder image">
                  <div class="live-status bg-success"></div>
                </a>
                <div class="media-body">
                  <div class="friend-header">Josephin Doe</div>
                  <span>20min ago</span>
                </div>
              </div>
              <div class="media friendlist-box" data-id="3" data-status="online" data-username="Alice"  data-toggle="tooltip" data-placement="left" title="Alice">
                <a class="mr-3" href="#!">
                  <img class="media-object rounded-circle" src="{{ asset('theme/assets/images/avatar-2.png') }}" alt="Generic placeholder image">
                  <div class="live-status bg-success"></div>
                </a>
                <div class="media-body">
                  <div class="friend-header">Alice</div>
                  <span>1 hour ago</span>
                </div>
              </div>
              <div class="media friendlist-box" data-id="1" data-status="online" data-username="Josephin Doe" data-toggle="tooltip" data-placement="left" title="Josephin Doe">

                <a class="mr-3" href="#!">
                  <img class="media-object rounded-circle" src="{{ asset('theme/assets/images/avatar-1.png') }}" alt="Generic placeholder image">
                  <div class="live-status bg-success"></div>
                </a>
                <div class="media-body">
                  <div class="friend-header">Josephin Doe</div>
                  <span>20min ago</span>
                </div>
              </div>
              <div class="media friendlist-box" data-id="1" data-status="online" data-username="Josephin Doe" data-toggle="tooltip" data-placement="left" title="Josephin Doe">

                <a class="mr-3" href="#!">
                  <img class="media-object rounded-circle" src="{{ asset('theme/assets/images/avatar-1.png') }}" alt="Generic placeholder image">
                  <div class="live-status bg-success"></div>
                </a>
                <div class="media-body">
                  <div class="friend-header">Josephin Doe</div>
                  <span>20min ago</span>
                </div>
              </div>
              <div class="media friendlist-box" data-id="1" data-status="online" data-username="Josephin Doe" data-toggle="tooltip" data-placement="left" title="Josephin Doe">

                <a class="mr-3" href="#!">
                  <img class="media-object rounded-circle" src="{{ asset('theme/assets/images/avatar-1.png') }}" alt="Generic placeholder image">
                  <div class="live-status bg-success"></div>
                </a>
                <div class="media-body">
                  <div class="friend-header">Josephin Doe</div>
                  <span>20min ago</span>
                </div>
              </div>
              <div class="media friendlist-box" data-id="1" data-status="online" data-username="Josephin Doe" data-toggle="tooltip" data-placement="left" title="Josephin Doe">

                <a class="mr-3" href="#!">
                  <img class="media-object rounded-circle" src="{{ asset('theme/assets/images/avatar-1.png') }}" alt="Generic placeholder image">
                  <div class="live-status bg-success"></div>
                </a>
                <div class="media-body">
                  <div class="friend-header">Josephin Doe</div>
                  <span>20min ago</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="showChat_inner">
      <div class="media chat-inner-header">
        <a class="back_chatBox">
          <i class="icofont icofont-rounded-left"></i> Josephin Doe
        </a>
      </div>
      <div class="media chat-messages">
        <a class="mr-3 photo-table" href="#!">
          <img class="media-object rounded-circle m-t-5" src="{{ asset('theme/assets/images/avatar-1.png') }}" alt="Generic placeholder image">
          <div class="live-status bg-success"></div>
        </a>
        <div class="media-body chat-menu-content">
          <div class="">
            <p class="chat-cont">I'm just looking around. Will you tell me something about yourself?</p>
            <p class="chat-time">8:20 a.m.</p>
          </div>
        </div>
      </div>
      <div class="media chat-messages">
        <div class="media-body chat-menu-reply">
          <div class="">
            <p class="chat-cont">I'm just looking around. Will you tell me something about yourself?</p>
            <p class="chat-time">8:20 a.m.</p>
          </div>
        </div>
        <div class="media-right photo-table">
          <a href="#!">
            <img class="media-object rounded-circle m-t-5" src="{{ asset('theme/assets/images/avatar-2.png') }}" alt="Generic placeholder image">
            <div class="live-status bg-success"></div>
          </a>
        </div>
      </div>
      <div class="media chat-reply-box">
        <div class="md-input-wrapper">
          <input type="text" class="md-form-control" id="inputEmail" name="inputEmail" >
          <label>Share your thoughts</label>
          <span class="highlight"></span>
          <span class="bar"></span>  <button type="button" class="chat-send waves-effect waves-light">
            <i class="icofont icofont-location-arrow f-20 "></i>
          </button>

        </div>
      </div>
    </div>
    <div class="content-wrapper">
      <div class="container-fluid">
        <div class="col-md-12">
          <br>
          @yield('content')
        </div> 
      </div>
    </div>
  </div>
</body>
</html>