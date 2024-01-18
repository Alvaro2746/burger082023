@extends('plantilla')

@section('titulo', "$titulo")

@section('scripts')
<script>
    globalId = '';
    <?php $globalId = "";?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/postulacion">postulacion;</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/postulacion/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    @if($globalId > 0)
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
    @endif
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/admin/postulaciones";
}
</script>
@endsection

@section('contenido')
<div class="panel-body">
        <div id = "msg"></div>
        <?php
if (isset($msg)) {
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
      <form id="form1" method="POST">
            <div class="row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                <div class="form-group col-lg-6">
                    <label>Nombre: *</label>
                    <input type="text" id="txtNombre" name="txtNombre" class="form-control"  required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Apellido: *</label>
                    <input type="text" id="txtApellido" name="txtApellido" class="form-control"  required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Whatsapp: *</label>
                    <input type="text" id="txtWhatsapp" name="txtWhatsapp" class="form-control"  required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Correo: *</label>
                    <input type="email" id="txtCorreo" name="txtCorreo" class="form-control"  required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Domicilio: *</label>
                    <input type="text" id="txtDomicilio" name="txtDomicilio" class="form-control"  required>
                </div>
                
                  <div class="form-group col-lg-12">
                        <div class="row">
                              <div class="form-group col-lg-12">
                                    <label>Cv: *</label>
                              </div>
                              <div class="form-group col-lg-12">
                                    <input type="file" id="txtCv" name="txtCv" class=""  required>
                              </div>
                        </div>
                  </div>
                    
            </div>
      </form>

      <script>
    function guardar() {
            if ($("#form1").valid()) {
                modificado = false;
                form1.submit(); //validacion
            } else {
                $("#modalGuardar").modal('toggle');
                msgShow("Corrija los errores e intente nuevamente.", "danger");
                return false;
            }
        }
</script>
                
@endsection
