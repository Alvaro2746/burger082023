<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


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
                      $menu_grupo = new MenuArea();
                      $menu_grupo->fk_idmenu = $entidad->idmenu;
                      $menu_grupo->eliminarPorMenu();
                      if ($request->input("chk_grupo") != null && count($request->input("chk_grupo")) > 0) {
                          foreach ($request->input("chk_grupo") as $grupo_id) {
                              $menu_grupo->fk_idarea = $grupo_id;
                              $menu_grupo->insertar();
                          }
                      }
                      $_POST["id"] = $entidad->idmenu;
                      return view('sistema.menu-listar', compact('titulo', 'msg'));
                  }
              } catch (Exception $e) {
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = ERRORINSERT;
              }
      
              $id = $entidad->idmenu;
              $menu = new Menu();
              $menu->obtenerPorId($id);
      
              $entidad = new Menu();
              $array_menu = $entidad->obtenerMenuPadre($id);
      
              $menu_grupo = new MenuArea();
              $array_menu_grupo = $menu_grupo->obtenerPorMenu($id);
      
              return view('sistema.menu-nuevo', compact('msg', 'menu', 'titulo', 'array_menu', 'array_menu_grupo')) . '?id=' . $menu->idmenu;
      
          }
      
      }
}

