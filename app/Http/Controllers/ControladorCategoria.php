<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Categoria;
require app_path().'/start/constants.php';

class ControladorCategoria extends Controller
{
      public function nuevo()
      {
            $titulo = "Nueva Categoria";
            return view('sistema.categoria-nuevo', compact('titulo'));
      }

      public function index()
      {
            $titulo = "Listado de Categorias";
            return view('sistema.categoria-listar', compact('titulo'));

      }
      public function guardar(Request $request)
      {
            try {
                  //Define la entidad servicio
                  $titulo = "Modificar Categoria";
                  $entidad = new Categoria();
                  $entidad->cargarDesdeRequest($request);
      
                  //validaciones
                  if ($entidad->nombrecategoria == "") {
                      $msg["ESTADO"] = MSG_ERROR;
                      $msg["MSG"] = "Complete todos los datos";
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
                      
                      $_POST["id"] = $entidad->idtipoproducto;
                      return view('sistema.categoria-listar', compact('titulo', 'msg'));
                  }
              } catch (Exception $e) {
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = ERRORINSERT;
              }

           
            
              return view('sistema.categoria-nuevo', compact('msg', 'titulo'));
      
          }
          public function cargarGrilla()
          {
              $request = $_REQUEST;
      
              $entidad = new Categoria();
              $aCategoria = $entidad->obtenerFiltrado();
      
              $data = array();
              $cont = 0;
      
              $inicio = $request['start'];
              $registros_por_pagina = $request['length'];
      
      
              for ($i = $inicio; $i < count($aCategoria) && $cont < $registros_por_pagina; $i++) {
                  $row = array();
                  $row[] = '<a href="/admin/categoria/' . $aCategoria[$i]->idtipoproducto . '">' . $aCategoria[$i]->nombrecategoria . '</a>';
                  $cont++;
                  $data[] = $row;
              }
      
              $json_data = array(
                  "draw" => intval($request['draw']),
                  "recordsTotal" => count($aCategoria), //cantidad total de registros sin paginar
                  "recordsFiltered" => count($aCategoria), //cantidad total de registros en la paginacion
                  "data" => $data,
              );
              return json_encode($json_data);
          }
          public function editar($id){
            $titulo = "Edicion de Categoria";
            $categoria= new Categoria();
            $categoria->obtenerPorId($id);
            return view('sistema.Categoria-nuevo', compact('titulo', 'categoria'));
        }
        public function eliminar(Request $request)
        {
            $id = $request->input('id');
    
                    $entidad = new Categoria();
                    $entidad->cargarDesdeRequest($request);
                                        
                    $entidad->eliminar();
                    $data["err"]=0;
                    return json_encode($data);                    

                    return view('sistema.categoria-listar', compact('cliente'));

        }

      }


