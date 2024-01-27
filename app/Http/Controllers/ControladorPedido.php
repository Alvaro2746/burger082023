<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Pedido;
use App\Entidades\Sistema\Producto;
use App\Entidades\Sistema\Productopedido;
require app_path().'/start/constants.php';

class ControladorPedido extends Controller
{
      public function nuevo()
      {
            $titulo = "Nuevo Pedido";
            return view('sistema.pedido-nuevo', compact('titulo'));
      }

      public function index()
      {
            $titulo = "Listado de Pedidos";
            return view('sistema.pedido-listar', compact('titulo'));

      }


          public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Pedido();
        $aPedido = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aPedido) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/pedido/' . $aPedido[$i]->idpedido . '">' . $aPedido[$i]->total . '</a>';
            $row[] = $aPedido[$i]->fk_idcarrito;
            $row[] = $aPedido[$i]->fk_idestado;
            $row[] = $aPedido[$i]->fecha;
            $row[] = $aPedido[$i]->metodo_pago;
            $row[] = $aPedido[$i]->fk_idsucursal;
            $row[] = $aPedido[$i]->fk_idcliente;
            $row[] = $aPedido[$i]->comentarios;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aPedido), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aPedido), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }
    public function editar($id){
        $titulo = "Edicion de Pedido";

        $pedido= new Pedido();
        $pedido->obtenerPorId($id);
        

        $productoPedido = new Productopedido();
        $aProductoPedidos = $productoPedido-> obtenerTodosPorPedido($pedido->idpedido);

        $producto = new Producto();
        
    
        for($i=0; $i<count($aProductoPedidos);$i++){
            $idaux=$aProductoPedidos[$i]->fk_idproducto;
            $aProductosaux = $producto->obtenerPorIdProducto($idaux); 
            $aProductos[]=$aProductosaux;
        }
        $tamanioGrilla=count($aProductos);
        

        

        return view('sistema.pedido-nuevo', compact('titulo', 'pedido', 'aProductoPedidos', 'aProductos', 'tamanioGrilla'));



    }

    public function cargarGrillaProducto()
    {
        $request = $_REQUEST;

        $producto = new Producto();
        $pedido = new Pedido();
        $productoPedido = new ProductoPedido();


        $productoPedido -> obtenerTodosPorPedido();
        $aProducto = $entidad->obtenerFiltrado();


        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        for ($i = $inicio; $i < count($aProducto) ; $i++) {
            $row = array();
            $row[] = '<img src="'.'/files/'.$aProducto[$i]->imagen.'" alt="Imagen del producto" class="img-thumbnail"></img>';
            $row[] = $aProducto[$i]->nombreproducto;
            $row[] = $aProducto[$i]->cantidad;
            $row[] = $aProducto[$i]->descripcion;
            $row[] = $aProducto[$i]->precio;
             
          //$row[] = '<img src="'.$aProducto[$i]->imagen.'" alt="" class="">';                
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aProducto), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aProducto), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }
    public function guardar(Request $request)
    {
          try {
                //Define la entidad servicio
                $titulo = "Modificar Pedido";
                $entidad = new Pedido();
                $entidad->cargarDesdeRequest($request);
    
                //validaciones
                if ($entidad->fk_idestado == "") {
                  
                    $msg["ESTADO"] = MSG_ERROR;
                    $msg["MSG"] = "Complete todos los datos";

                    $id = $entidad->idpedido;
                    $pedido = new Pedido();
                    $pedido->obtenerPorId($id);
            
                    return view('sistema.pedido-nuevo', compact('msg', 'pedido', 'titulo', 'array_pedido', 'array_pedido_grupo')) . '?id=' . $pedido->idpedido;
      
                } else {
                  
                    if ($_POST["id"] > 0) {
                        //Es actualizacion
                        $entidad->guardar();
    
                        $msg["ESTADO"] = MSG_SUCCESS;
                        $msg["MSG"] = OKINSERT;
                    } else {
                        //Es nuevo
                        $entidad->insertar();
    
                        $msg["ESTADO"] = MSG_SUCCESS;
                        $msg["MSG"] = OKINSERT;
                    }
                    
                    $_POST["id"] = $entidad->idpedido;
                    return view('sistema.pedido-listar', compact('titulo', 'msg'));
                    $titulo="Listado de Pedidos";
                }
            } catch (Exception $e) {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = ERRORINSERT;
            }


      }


    }