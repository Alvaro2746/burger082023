<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Cliente;
require app_path().'/start/constants.php';

class ControladorCliente extends Controller
{
      public function nuevo()
      {
            $titulo = "Nuevo cliente";
            return view('sistema.cliente-nuevo', compact('titulo'));
      }

      public function index()
      {
            $titulo = "Listado de Clientes";
            return view('sistema.cliente-listar', compact('titulo'));

      }
      public function guardar(Request $request)
      {
            try {
                  //Define la entidad servicio
                  $titulo = "Modificar Cliente";
                  $entidad = new Cliente();
                  $entidad->cargarDesdeRequest($request);
      
                  //validaciones
                  if ($entidad->nombre == "") {
                    
                      $msg["ESTADO"] = MSG_ERROR;
                      $msg["MSG"] = "Complete todos los datos";

                      $id = $entidad->idcliente;
                      $cliente = new Cliente();
                      $cliente->obtenerPorId($id);
              
                      return view('sistema.cliente-nuevo', compact('msg', 'cliente', 'titulo', 'array_cliente', 'array_cliente_grupo')) . '?id=' . $cliente->idcliente;
        
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
                      
                      $_POST["id"] = $entidad->idcliente;
                      return view('sistema.cliente-listar', compact('titulo', 'msg'));
                      $titulo="Listado de Clientes";
                  }
              } catch (Exception $e) {
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = ERRORINSERT;
              }
      
      
          }

          public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Cliente();
        $aCliente = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aCliente) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/cliente/' . $aCliente[$i]->idcliente . '">' . $aCliente[$i]->nombre . '</a>';
            $row[] = $aCliente[$i]->apellido;
            $row[] = $aCliente[$i]->dni;
            $row[] = $aCliente[$i]->telefono;
            $row[] = $aCliente[$i]->correo;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aCliente), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aCliente), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }
    public function editar($id){
        $titulo = "Edicion de cliente";
        $cliente= new Cliente();
        $cliente->obtenerPorId($id);
        return view('sistema.cliente-nuevo', compact('titulo', 'cliente'));
    }
            public function eliminar(Request $request)
        {
            $id = $request->input('id');
    
                    $entidad = new Cliente();
                    $entidad->cargarDesdeRequest($request);
                                        
                    $entidad->eliminar();
                    
                    return view('sistema.cliente-listar', compact('entidad'));

        }
        

      }


