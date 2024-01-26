
<?php 
//TEST

// echo count($array_categoria);
// exit;
?>


@extends('plantilla')

@section('titulo', "$titulo")

@section('scripts')
<script>
    globalId = '<?php echo isset($producto->idproducto) && $producto->idproducto > 0 ? $producto->idproducto : 0; ?>';
    <?php $globalId = isset($producto->idproducto) ? $producto->idproducto : "0";?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/producto">producto;</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/producto/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    @if($globalId > 0)
    <li class="btn-item"><a title="Eliminar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
    @endif
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/admin/productos";
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
      <form id="form1"  method="POST" enctype="multipart/form-data">
            <div class="row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                <div class="form-group col-lg-6">
                    <label>Nombre: *</label>
                    <input type="text" id="txtNombreProducto" name="txtNombreProducto" class="form-control"  value="<?php echo isset($producto->nombreproducto)? $producto->nombreproducto : ''; ?>" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Cantidad: *</label>
                    <input type="number" id="txtCantidad" name="txtCantidad" class="form-control" value="<?php echo isset($producto->cantidad)? $producto->cantidad : ''; ?>" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Precio: *</label>
                    <input type="number" id="txtPrecio" name="txtPrecio" class="form-control" value="<?php echo isset($producto->precio)? $producto->precio : ''; ?>" required>
                </div>
                

                <div class="form-group col-lg-6">
                    
                <label>Categoria: *</label>
                <select id="txtCategoria" name="txtCategoria" class="form-control"  required>

                    @if($globalId > 0)
                    
                    <option  value="" disabled>Seleccionar</option>
                    @for ($i = 0; $i < count($array_categoria); $i++)
                            @if ($array_categoria[$i]->idtipoproducto == $producto->fk_idtipoproducto)
                                <option selected value="{{ $array_categoria[$i]->idtipoproducto }}">{{ $array_categoria[$i]->nombrecategoria }}</option>
                            @else
                                <option value="{{ $array_categoria[$i]->idtipoproducto }}">{{ $array_categoria[$i]->nombrecategoria }}</option>
                            @endif
                        @endfor
                        </select>
                        </div>

                    @else
                    

                    <option  value="" selected disabled>Seleccionar</option>
                    @for ($i = 0; $i < count($array_categoria); $i++)
                            @if (isset($categoria) and $array_categoria[$i]->idtipoproducto == $categoria->idtipoproducto)
                                <option selected value="{{ $array_categoria[$i]->idtipoproducto }}">{{ $array_categoria[$i]->nombrecategoria }}</option>
                            @else
                                <option value="{{ $array_categoria[$i]->idtipoproducto }}">{{ $array_categoria[$i]->nombrecategoria }}</option>
                            @endif
                        @endfor
                        </select>
                        </div>

                    @endif
                  


                <div class="form-group col-lg-12">
                    <label>Descripcion: *</label>
                    <input type="text" id="txtDescripcion" name="txtDescripcion" class="form-control" value="<?php echo isset($producto->descripcion)? $producto->descripcion : ''; ?>" required>
                </div>

                <div class="form-group col-lg-12">
                        <div class="row">
                              <div class="form-group col-lg-12">
                                    <label>Imagen: </label>
                              </div>
                              <div class="form-group col-lg-12">
                                    <input type="file" id="archivo" name="archivo" class="" <?php echo isset($globalId) && $globalId>0? "" :"required"; ?> >
                              </div>
                        </div>
                  </div>

                <script>
                  ClassicEditor
                  .create(document.querySelector("txtDescripcion"))
                  .catch(error =>{
                        console.error(error);
                  });
                </script>
            
                    
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
        function eliminar() {
            $.ajax({
                type: "GET",
                url: "{{ asset('admin/producto/eliminar') }}",
                data: { id:globalId },
                async: true,
                dataType: "json",
                success: function (data) {
                    if (data.err = "0") {
                        msgShow("Registro eliminado exitosamente.", "success");
                    } else {
                        msgShow(data.err, "danger");
                    }
                    $('#mdlEliminar').modal('toggle');
                }
            });
        }
</script>
                
@endsection
