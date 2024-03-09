<?php
// print_r($_SESSION);
// exit;
?>
@extends("web.plantilla")
@section('contenido')
    <!-- Product Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-0 gx-5 align-items-end">
                <div class="col-lg-6">
                    <div class="section-header text-start mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                        <h1 class="display-5 mb-3">Mi Cuenta</h1>
                        <p>informacion sobre tu cuenta.</p>
                    </div>
                </div>
            </div>

            <div class="container">
              <div class="row justify-content-center wow fadeInUp" data-wow-delay="0.2s">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    <div class="container">
        <table>
            <tr>
                <th>Nombre y Apellido</th>
                <td>{{session('cliente_nombre')}}</td>
            </tr>
            <tr>
                <th>Teléfono</th>
                <td>{{session('telefono')}}</td>
            </tr>
            <tr>
                <th>Correo</th>
                <td>{{session('correo')}}</td>
            </tr>
            <tr>
                <th>Contraseña</th>
                <td><input type="password" value="contraseña_actual"></td>
            </tr>
            <tr>
                <th>Nueva Contraseña</th>
                <td><input type="password" placeholder="Nueva contraseña"></td>
            </tr>
            <tr>
                <th>Confirmar Contraseña</th>
                <td><input type="password" placeholder="Confirmar contraseña"></td>
            </tr>
            <tr>
                <td colspan="2"><button>Guardar cambios</button></td>
            </tr>
        </table>
    </div>



</div>

              
            </div>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane fade show p-0 active">
                    <div class="row g-4">
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product End -->

@endsection