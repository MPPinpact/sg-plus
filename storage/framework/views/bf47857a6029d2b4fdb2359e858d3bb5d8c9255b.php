<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
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
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Laravel')); ?></title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <!-- CSS -->
    <!--ico Fonts-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('theme/assets/icon/icofont/css/icofont.css')); ?>">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('theme/bower_components/bootstrap/css/bootstrap.min.css')); ?>">
    <!-- Material icons -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('theme/assets/icon/material-design/css/material-design-iconic-font.min.css')); ?>">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('theme/assets/css/main.css')); ?>">
    <!-- Responsive.css-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('theme/assets/css/responsive.css')); ?>">
    <!--color css-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('theme/assets/css/color/color-1.css')); ?>" id="color"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/validator/formValidation.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/login/login.css')); ?>">
    <!-- JS -->
    <!-- Required Jqurey -->
    <script type="text/javascript" src="<?php echo e(asset('theme/bower_components/jquery/js/jquery.min.js')); ?>"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script> -->
    <!-- <script src="<?php echo e(asset('theme/assets/plugins/forms-wizard-validation/js/validate.js')); ?>"></script> -->
    <script src="<?php echo e(asset('js/utils/utils.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/validator/formValidation.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/validator/fvbootstrap.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/validator/es_ES.js')); ?>"></script>
    <!-- <script type="text/javascript" src="<?php echo e(asset('theme/bower_components/jquery-ui/js/jquery-ui.min.js')); ?>"></script> -->
    <!-- tether.js -->
    <!-- <script type="text/javascript" src="<?php echo e(asset('theme/bower_components/popper.js/js/popper.min.js')); ?>"></script> -->
    <!-- waves effects.js -->
    <!-- <script src="<?php echo e(asset('theme/assets/plugins/waves/js/waves.min.js')); ?>"></script> -->
    <!-- Required Framework -->
    <!-- <script type="text/javascript" src="<?php echo e(asset('theme/bower_components/bootstrap/js/bootstrap.min.js')); ?>"></script> -->
    <!-- waves effects.js -->
    <!-- <script src="<?php echo e(asset('theme/assets/plugins/waves/js/waves.min.js')); ?>"></script> -->
    <!-- Scrollbar JS-->
    <!-- <script type="text/javascript" src="<?php echo e(asset('theme/bower_components/jquery-slimscroll/js/jquery.slimscroll.js')); ?>"></script> -->
    <!-- <script type="text/javascript" src="<?php echo e(asset('theme/assets/plugins/jquery.nicescroll/js/jquery.nicescroll.min.js')); ?>"></script> -->
    <!--classic JS-->
    <!-- <script type="text/javascript" src="<?php echo e(asset('theme/bower_components/classie/js/classie.js')); ?>"></script> -->
    <!-- notification -->
    <script type="text/javascript" src="<?php echo e(asset('theme/assets/plugins/notification/js/bootstrap-growl.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/utils/utils.js')); ?>"></script>
    <!-- custom js -->
    <!-- <script type="text/javascript" src="<?php echo e(asset('theme/assets/js/main.min.js')); ?>"></script> -->
    <!-- <script type="text/javascript" src="<?php echo e(asset('theme/assets/pages/elements.js')); ?>"></script> -->
    <!-- <script src="<?php echo e(asset('theme/assets/js/menu-horizontal.min.js')); ?>"></script> -->
</head>
<body onLoad="if ('Navigator' == navigator.appName)document.forms[0].reset();">
    <div id="app">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</body>
</html>