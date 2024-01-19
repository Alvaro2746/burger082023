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
      
      }


