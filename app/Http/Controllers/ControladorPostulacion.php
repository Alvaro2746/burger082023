<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Postulacion;
require app_path().'/start/constants.php';

class ControladorPostulacion extends Controller
{
      public function nuevo()
      {
            $titulo = "Nueva postulacion";
            return view('sistema.postulacion-nuevo', compact('titulo'));
      }
      public function index()
      {
            $titulo = "Listado de Postulaciones";
            return view('sistema.Postulacion-listar', compact('titulo'));

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

}