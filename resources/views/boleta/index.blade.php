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
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>{{ config('app.name', 'Laravel') }}</title>
  
  <style>
  .TextoGrande {
    font-family :arial;
    font-size   : 12.5pt;
    font-weight :bold;
  }

  /* ESTILO TEXTO GIRO EMPRESA */
  .TextoGiro {
    font-family :arial;
    font-size   :12pt;
  }

   /* TITULO DE TABLAS */
          .TablaTitulo
          {
          background:#D8D8D8;
          font-family: verdana;
          font-size:10pt;
          text-align:left;
          border-bottom:2px solid black;
          }

          /* TITULO DE TABLAS */
          .TablaDetalle
          {
          /* background:#D8D8D8; */
          font-family: verdana;
          font-size:10pt;
          text-align:left;
          

          }

  </style>
</head>
<body style="padding-top:20px">
@yield('content')
</body>
</html>