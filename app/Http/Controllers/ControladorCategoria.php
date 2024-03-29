<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Categoria;
use App\Entidades\Sistema\Producto;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;

require app_path().'/start/constants.php';

class ControladorCategoria extends Controller
{
      public function nuevo()
      {
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("PRODUCTOCONSULTA")) {
                $codigo = "PRODUCTOCONSULTA";
                $mensaje = "No tiene permisos para la operación.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $titulo = "Nueva Categoria";
                return view('sistema.categoria-nuevo', compact('titulo'));
                }
        } else {
            return redirect('admin/login');
        }


      }

      public function index()
      {
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("PRODUCTOCONSULTA")) {
                $codigo = "PRODUCTOCONSULTA";
                $mensaje = "No tiene permisos para la operación.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $titulo = "Listado de Categorias";
                return view('sistema.categoria-listar', compact('titulo'));
                }
        } else {
            return redirect('admin/login');
        }


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

            if (Usuario::autenticado() == true) {
                if (!Patente::autorizarOperacion("CLIENTEALTA")) {
                    $codigo = "CLIENTEALTA";
                    $mensaje = "No tiene permisos para la operación.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                    $categoria= new Categoria();
                    $categoria->obtenerPorId($id);
                    return view('sistema.Categoria-nuevo', compact('titulo', 'categoria'));
                        }
            } else {
                return redirect('admin/login');
            }
    

        }
        public function eliminar(Request $request)
        {
            if (Usuario::autenticado() == true) {
                if (!Patente::autorizarOperacion("CLIENTEALTA")) {
                    $codigo = "CLIENTEALTA";
                    $mensaje = "No tiene permisos para la operación.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                    $id = $request->input('id');
    
                    $producto= new Producto();
                    $aProducto=$producto->obtenerPorCategoria($id);
                    // print_r($aProducto);
                    // exit;
                    if(count($aProducto) == 0){
                        $categoria = new Categoria();
                        $categoria->idtipoproducto=$id;
                        $categoria->eliminar();
                        $data["err"]="OK";
                        }else{
                            $data["err"] = "No se puede eliminar categoria con productos asociados";
                        }
                        return json_encode($data);                    
                }
            } else {
                return redirect('admin/login');
            }
        }

      }


