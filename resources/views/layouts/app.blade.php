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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <!-- CSS -->
	
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/bower_components/bootstrap/css/bootstrap.min.css') }}">

    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/assets/css/main_login.css') }}">
    <!-- Responsive.css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/assets/css/responsive.css') }}">
    <!--color css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/assets/css/color/color-1.css') }}" id="color"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/validator/formValidation.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login/login.css') }}">
    <!-- JS -->
    <!-- Required Jqurey -->
    <script type="text/javascript" src="{{ asset('theme/bower_components/jquery/js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/utils/utils.js') }}"></script>
    <script src="{{ asset('plugins/validator/formValidation.js') }}"></script>
    <script src="{{ asset('plugins/validator/fvbootstrap.js') }}"></script>
    <script src="{{ asset('plugins/validator/es_ES.js') }}"></script>

    <script src="{{ asset('theme/assets/plugins/notification/js/bootstrap-growl.min.js') }}"></script>
    
    <script type="text/javascript" src="{{ asset('js/utils/utils.js') }}"></script>
    
</head>
<body onLoad="if ('Navigator' == navigator.appName)document.forms[0].reset();">
    <div id="app">
        @yield('content')
    </div>
</body>
</html>