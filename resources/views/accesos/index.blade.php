<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <!-- Meta -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
  <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!-- CSS -->
  {!! Html::style('theme/assets/icon/icofont/css/icofont.css') !!}
  {!! Html::style('theme/assets/icon/simple-line-icons/css/simple-line-icons.css') !!}
  {!! Html::style('theme/bower_components/bootstrap/css/bootstrap.min.css') !!}
  {!! Html::style('theme/assets/css/main.css') !!}
  {!! Html::style('theme/assets/css/responsive.css') !!}
  {!! Html::style('theme/assets/css/color/color-1.css') !!}
  {!! Html::style('plugins/validator/formValidation.css') !!}
  {!! Html::style('css/login/login.css') !!}
  <!-- JS -->
  {{ HTML::script('theme/bower_components/jquery/js/jquery.min.js') }} 
  {{ HTML::script('theme/bower_components/jquery-ui/js/jquery-ui.min.js') }} 
  {{ HTML::script('theme/bower_components/popper.js/js/popper.min.js') }} 
  {{ HTML::script('theme/bower_components/bootstrap/js/bootstrap.min.js') }} 
  
  {{ HTML::script('theme/assets/plugins/notification/js/bootstrap-growl.min.js') }} 
  {{ HTML::script('js/login/main.js') }} 
  {{ HTML::script('js/utils/utils.js') }} 
</head>
<body class="horizontal-fixed fixed">
    <form id="formLogout" method="POST" style="display: none;">
      {{ csrf_field() }}
    </form>
    <div class="wrapper">
        <div class="loader-bg">
            <div class="loader-bar"></div>
        </div>
        @include('accesos.menu_navbar')
        <div class="content-wrapper">
            <div class="container-fluid">
              @yield('content')
            </div>
        </div>
    </div>
</body>
</html>