<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Postulacion;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
require app_path().'/start/constants.php';

class ControladorPostulacion extends Controller
{
      public function nuevo()
      {
            $titulo = "Nueva postulacion";
            if (Usuario::autenticado() == true) {
                if (!Patente::autorizarOperacion("POSTULANTEALTA")) {
                    $codigo = "POSTULANTEALTA";
                    $mensaje = "No tiene permisos para la operación.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                    return view('sistema.postulacion-nuevo', compact('titulo'));
                }
            } else {
                return redirect('admin/login');
            }
    
      }
      public function index()
      {
            $titulo = "Listado de Postulaciones";
            if (Usuario::autenticado() == true) {
                if (!Patente::autorizarOperacion("POSTULANTECONSULTA")) {
                    $codigo = "POSTULANTECONSULTA";
                    $mensaje = "No tiene permisos para la operación.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                    return view('sistema.Postulacion-listar', compact('titulo'));
                }
            } else {
                return redirect('admin/login');
            }
    

      }
      public function guardar(Request $request)
      {
            try {
                  //Define la entidad servicio
                  $titulo = "Modificar Postulacion";
                  $entidad = new Postulacion();
                  $entidad->cargarDesdeRequest($request);
      
                  //validaciones
                  if ($entidad->nombre == "") {
                    
                      $msg["ESTADO"] = MSG_ERROR;
                      $msg["MSG"] = "Complete todos los datos";

                      $id = $entidad->idpostulacion;
                      $postulacion = new Postulacion();
                      $postulacion->obtenerPorId($id);
              
                      return view('sistema.postulacion-nuevo', compact('msg', 'postulacion', 'titulo', 'array_postulacion', 'array_postulacion_grupo')) . '?id=' . $postulacion->idpostulacion;
        
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
                      
                      $_POST["id"] = $entidad->idpostulacion;
                      return view('sistema.postulacion-listar', compact('titulo', 'msg'));
                      $titulo="Listado de Postulaciones";
                  }
              } catch (Exception $e) {
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = ERRORINSERT;
              }
      
      
          }
          public function cargarGrilla()
          {
              $request = $_REQUEST;
      
              $entidad = new Postulacion();
              $aPostulacion = $entidad->obtenerFiltrado();
      
              $data = array();
              $cont = 0;
      
              $inicio = $request['start'];
              $registros_por_pagina = $request['length'];
      
      
              for ($i = $inicio; $i < count($aPostulacion) && $cont < $registros_por_pagina; $i++) {
                  $row = array();
                  $row[] = '<a href="/admin/postulacion/' . $aPostulacion[$i]->idpostulacion . '">' . $aPostulacion[$i]->nombre . '</a>';
                  $row[] = $aPostulacion[$i]->apellido;
                  $row[] = $aPostulacion[$i]->email;
                  $row[] = $aPostulacion[$i]->domicilio;
                  $row[] = $aPostulacion[$i]->whatsapp;
                  $row[] = $aPostulacion[$i]->cv;
                  $cont++;
                  $data[] = $row;
              }
      
              $json_data = array(
                  "draw" => intval($request['draw']),
                  "recordsTotal" => count($aPostulacion), //cantidad total de registros sin paginar
                  "recordsFiltered" => count($aPostulacion), //cantidad total de registros en la paginacion
                  "data" => $data,
              );
              return json_encode($json_data);
          }
      
          public function editar($id){
            $titulo = "Edicion de postulacion";
            if (Usuario::autenticado() == true) {
                if (!Patente::autorizarOperacion("POSTULANTEEDITAR")) {
                    $codigo = "POSTULANTEEDITAR";
                    $mensaje = "No tiene permisos para la operación.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                    $postulacion= new Postulacion();
                    $postulacion->obtenerPorId($id);
                    return view('sistema.postulacion-nuevo', compact('titulo', 'postulacion'));
                        }
            } else {
                return redirect('admin/login');
            }
    
        }
        public function eliminar(Request $request)
        {
            if (Usuario::autenticado() == true) {
                if (!Patente::autorizarOperacion("POSTULANTEBAJA")) {
                    $codigo = "POSTULANTEBAJA";
                    $mensaje = "No tiene permisos para la operación.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                    $id = $request->input('id');
    
                    $entidad = new Postulacion();
                    $entidad->cargarDesdeRequest($request);
                                        
                    $entidad->eliminar();
                    $data["err"]=0;
                    return json_encode($data);                    
                    
                    return view('sistema.postulacion-listar', compact('cliente'));
                }
            } else {
                return redirect('admin/login');
            }
    

        }

}