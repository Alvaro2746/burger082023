<?php
// $claveIngresada="clave";
// $claveBBDD=password_hash("clave", PASSWORD_DEFAULT);

// echo $claveIngresada;
// echo $claveBBDD;




?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    <title>{{ $titulo }} -  {{ env('APP_NAME') }}</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin.min.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/funciones_generales.js') }}"></script>
  </head>
  
<body class="bg-dark">
    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Acceso</div>
        <div class="card-body">
          <?php
          if (isset($msg)) {
              echo '<div id = "msg"></div>';
              echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
          }
          ?>
          <form name="fr" class="form-signin" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" id="txtCorreo" name="txtCorreo" class="form-control" placeholder="Usuario" required autofocus>
                <label for="txtCorreo">Correo</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" id="txtClave" name="txtClave" class="form-control" placeholder="Clave" >
                <label for="txtClave">Clave</label>
              </div>
            </div>
            <div class="form-group">
              <div class="checkbox">
                <label>
                  
              </div>
            </div>
            <button class="btn btn-primary btn-block" type="submit">Entrar</button>
          </form><br>
          
        </div>
      </div>
    </div>
  </body>
</html>