<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Sucursal;
require app_path().'/start/constants.php';

class ControladorSucursal extends Controller
{
      public function nuevo()
      {
            $titulo = "Nueva sucursal";
            return view('sistema.sucursal-nuevo', compact('titulo'));
      
      }
      public function index()
      {
            $titulo = "Listado de Sucursales";
            return view('sistema.sucursal-listar', compact('titulo'));

      }
      public function guardar(Request $request)
      {
            try {
                  //Define la entidad servicio
                  $titulo = "Modificar Sucursal";
                  $entidad = new Sucursal();
                  $entidad->cargarDesdeRequest($request);
      
                  //validaciones
                  if ($entidad->nombresucursal == "") {
                    
                      $msg["ESTADO"] = MSG_ERROR;
                      $msg["MSG"] = "Complete todos los datos";

                      $id = $entidad->idsucursal;
                      $sucursal = new Sucursal();
                      $sucursal->obtenerPorId($id);
              
                      return view('sistema.sucursal-nuevo', compact('msg', 'sucursal', 'titulo', 'array_sucursal', 'array_sucursal_grupo')) . '?id=' . $sucursal->idsucursal;
        
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
                      
                      $_POST["id"] = $entidad->idsucursal;
                      return view('sistema.sucursal-listar', compact('titulo', 'msg'));
                      $titulo="Listado de sucursales";
                  }
              } catch (Exception $e) {
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = ERRORINSERT;
              }
      
            }
            public function cargarGrilla()
            {
                $request = $_REQUEST;
        
                $entidad = new Sucursal();
                $aSucursal = $entidad->obtenerFiltrado();
        
                $data = array();
                $cont = 0;
        
                $inicio = $request['start'];
                $registros_por_pagina = $request['length'];
        
        
                for ($i = $inicio; $i < count($aSucursal) && $cont < $registros_por_pagina; $i++) {
                    $row = array();
                    $row[] = '<a href="/admin/sucursal/' . $aSucursal[$i]->idsucursal . '">' . $aSucursal[$i]->nombresucursal . '</a>';
                    $row[] = $aSucursal[$i]->direccionsucursal;
                    $row[] = $aSucursal[$i]->estado_sucursal;

                    $cont++;
                    $data[] = $row;
                }
        
                $json_data = array(
                    "draw" => intval($request['draw']),
                    "recordsTotal" => count($aSucursal), //cantidad total de registros sin paginar
                    "recordsFiltered" => count($aSucursal), //cantidad total de registros en la paginacion
                    "data" => $data,
                );
                return json_encode($json_data);
            }
            public function editar($id){
                $titulo = "Edicion de sucursal";
                $sucursal= new Sucursal();
                $sucursal->obtenerPorId($id);
                return view('sistema.sucursal-nuevo', compact('titulo', 'sucursal'));
            }
        
          }