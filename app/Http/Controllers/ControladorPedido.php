<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Pedido;
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
        return view('sistema.pedido-nuevo', compact('titulo', 'pedido'));
    }
      }


