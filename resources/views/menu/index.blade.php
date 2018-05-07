<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" >

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
  {!! Html::style('theme/bower_components/select2/css/select2.min.css') !!}
  {!! Html::style('plugins/validator/formValidation.min.css') !!}
  {!! Html::style('plugins/jQuery-contextMenu-master/dist/jquery.contextMenu.min.css') !!}
  {!! Html::style('css/login/login.css') !!}
  <!-- JS -->
  <script type="text/javascript" src="{{ asset('theme/bower_components/jquery/js/jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('theme/bower_components/jquery-ui/js/jquery-ui.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('theme/bower_components/popper.js/js/popper.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('theme/bower_components/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('theme/assets/plugins/waves/js/waves.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('theme/bower_components/jquery-slimscroll/js/jquery.slimscroll.js') }}"></script>
  <script type="text/javascript" src="{{ asset('theme/assets/plugins/jquery.nicescroll/js/jquery.nicescroll.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('theme/bower_components/classie/js/classie.js') }}"></script>
  <script src="{{ asset('theme/assets/plugins/notification/js/bootstrap-growl.min.js') }}"></script>
  <script src="{{ asset('theme/bower_components/jquery-sparkline/js/jquery.sparkline.js') }}"></script>
  <script type="text/javascript" src="{{ asset('theme/bower_components/waypoints/js/jquery.waypoints.min.js') }}"></script>
  <script src="{{ asset('theme/assets/plugins/countdown/js/jquery.counterup.js') }}"></script>
  {{ HTML::script('theme/bower_components/select2/js/select2.full.min.js') }}
  {{ HTML::script('theme/bower_components/datatables.net/js/jquery.dataTables.min.js') }}
  {{ HTML::script('theme/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}
  {{ HTML::script('theme/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js') }}
  {{ HTML::script('theme/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js') }}
  {{ HTML::script('theme/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}


  {{ HTML::script('theme/bower_components/datatables.net/js/jquery.dataTables.min.js') }}
  {{ HTML::script('theme/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js') }}
  {{ HTML::script('theme/assets/plugins/data-table/js/jszip.min.js') }}
  {{ HTML::script('theme/assets/plugins/data-table/js/pdfmake.min.js') }}
  {{ HTML::script('theme/assets/plugins/data-table/js/vfs_fonts.js') }}
  {{ HTML::script('theme/bower_components/datatables.net-buttons/js/buttons.print.min.js') }}
  {{ HTML::script('theme/bower_components/datatables.net-buttons/js/buttons.html5.min.js') }}
  {{ HTML::script('theme/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}
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
  {{ HTML::script('theme/assets/plugins/form-mask/js/inputmask.js') }}
  {{ HTML::script('theme/assets/plugins/form-mask/js/jquery.inputmask.js') }}
  {{ HTML::script('theme/assets/plugins/form-mask/js/autoNumeric.js') }}
  {{ HTML::script('plugins/validator/formValidation.min.js') }}
  {{ HTML::script('plugins/validator/fvbootstrap.min.js') }}
  {{ HTML::script('plugins/validator/es_ES.min.js') }}
  {{ HTML::script('plugins/daterangepicker/moment.js') }}
  {{ HTML::script('plugins/daterangepicker/moment-with-locale-es.js') }}
  {{ HTML::script('plugins/jQuery-contextMenu-master/dist/jquery.contextMenu.min.js') }}
  {{ HTML::script('plugins/validator/valtexto.js') }}
  {{ HTML::script('plugins/printArea/jquery.printarea.js') }}
  {{ HTML::script('plugins/jsBarcode/JsBarcode.code39.min.js') }}
  {{ HTML::script('js/utils/utils.js') }}
  {{ HTML::script('js/index/index.js') }}
</head>
<body class="horizontal-fixed fixed">
  <div class="wrapper">
    <div class="loader-bg">
      <div class="loader-bar"></div>
    </div>
    <!-- Navbar-->
    <header class="main-header-top hidden-print">
      @include('index.menu_navbar')
    </header>
    <!-- Side-Nav--> 
    <!-- menu mobile -->
    <aside class="main-sidebar hidden-print ">
      @include('index.menu_aside')
    </aside>
    <!-- Sidebar chat end-->
    <div class="content-wrapper">
      <div class="container-fluid">
        @yield('content')
      </div>
    </div>
  </div>
  <script type="text/javascript" src="{{ asset('js/index/main.js') }}"></script>
  <script src="{{ asset('theme/assets/js/menu-horizontal.min.js') }}"></script>
  <script Language="Javascript">
    var rutaHome = "{{ URL::route('infoDashboard') }}"
  </script>
</body>
</html>