<?php
// print_r($aProductos);
// // echo $aProductos->nombreproducto;
// exit;
?>

@extends('plantilla')

@section('titulo', "$titulo")

@section('scripts')
<script>
    globalId = '<?php echo isset($pedido->idpedido) && $pedido->idpedido > 0 ? $pedido->idpedido : 0; ?>';
    <?php $globalId = isset($pedido->idpedido) ? $pedido->idpedido : "0";
    
    ?>
    
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/clientes">Clientes;</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/pedido/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    @if($globalId > 0)
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
    @endif
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/admin/pedidos";
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


                <div class="form-group col-lg-12">
                    <input type="text" id="#pedido" name="pedido" class="form-control" disabled value="Pedido #<?php echo isset($globalId)? $globalId : ''; ?>" >
                </div>
                <div class="form-group col-lg-6">
                    <label>Cliente:</label>
                    <input type="text" id="txtCliente" name="txtCliente" class="form-control" disabled value="<?php echo isset($pedido->fk_idcliente)? $pedido->fk_idcliente : ''; ?>" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Sucursal: </label>
                    <input type="text" id="txtSucursal" name="txtSucursal" class="form-control" disabled value="<?php echo isset($pedido->fk_idsucursal)? $pedido->fk_idsucursal : ''; ?>" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Fecha y Hora: </label>
                    <input type="text" id="txtFecha" name="txtFecha" class="form-control" disabled value="<?php echo isset($pedido->fecha)? $pedido->fecha : ''; ?>" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Estado: </label>
                    <input type="text" id="txtEstado" name="txtEstado" class="form-control" value="<?php echo isset($pedido->fk_idestado)? $pedido->fk_idestado : ''; ?>" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Comentarios: </label>
                    <input type="text" id="txtComentarios" name="txtComentarios" class="form-control" disabled value="<?php echo isset($pedido->comentarios)? $pedido->comentarios : ''; ?>" required>
                </div>
                <div class="form-group col-lg-6">
                    <label>Metodo de Pago: </label>
                    <select id="txtPago" name="txtPago" class="form-control">
                        <option <?php echo isset($pedido->metodo_pago) && $pedido->metodo_pago=="Efectivo"? 'Selected' : ''; ?> selected value="Efectivo">Efectivo</option>
                        <option <?php echo isset($pedido->metodo_pago) && $pedido->metodo_pago=="Tarjeta"? 'Selected' : ''; ?> value="Tarjeta">Tarjeta</option>
                    </select>

                </div>   
            </div>
      </form>


<table id="" class="table table-bordered">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Descripcion</th>
            <th>Precio</th>
        </tr>
    </thead>
    <tbody>
    <?php $total=0 ; ?>

    @for($i = 0; $i < $tamanioGrilla; $i++)
        <tr>
            <td>
                <img src="/files/{{ $aProductos[$i][0]->imagen }}" class="img-fluid" alt="Imagen {{ $i }}">
            </td>
            <td>{{ $aProductos[$i][0]->nombreproducto }}</td>
            <td>{{ $aProductoPedidos[$i]->cantidad }}</td>
            <td>{{ $aProductos[$i][0]->descripcion }}</td>
            <td>{{ $aProductoPedidos[$i]->precio_unitario }}</td>
            <?php $total += ($aProductoPedidos[$i]->precio_unitario * $aProductoPedidos[$i]->cantidad) ; ?>
        </tr>
@endfor
        <tr>
            <td colspan="4"></td>
            <th><h3>Total</h3></th>
        </tr>
        <tr>
        <td colspan="4"></td>
        <td>{{ $total }}</td>
        </tr>

</tbody>

</table>



<table>
</table>
 
<script>
	
</script>


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
                url: "{{ asset('admin/cliente/eliminar') }}",
                data: { id:globalId },
                async: true,
                dataType: "json",
                success: function (data) {
                    if (data.err == "OK") {
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
