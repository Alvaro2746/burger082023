<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Producto;
use App\Entidades\Sistema\Categoria;
require app_path().'/start/constants.php';

class ControladorProducto extends Controller
{
      public function nuevo()
      {
            $titulo = "Nuevo Producto";

            $categoria = new Categoria();
            $array_categoria = $categoria->obtenerTodos();

            //  print_r($array_categoria);
            //  exit;
            
            return view('sistema.producto-nuevo', compact('titulo', 'categoria', 'array_categoria' ));


    
            
      }
      public function index()
      {
            $titulo = "Listado de Productos";
            return view('sistema.Producto-listar', compact('titulo'));

      }
      public function guardar(Request $request)
      {
            try {
                  //Define la entidad servicio
                  $titulo = "Modificar Producto";
                  $entidad = new Producto();
                  $entidad->cargarDesdeRequest($request);

                //   if ($_FILES["archivo"]["error"] === UPLOAD_ERR_OK) { //Se adjunta imagen
                //     $extension = pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION);
                //      $nombre = date("Ymdhmsi") . ".$extension";
                //      $archivo = $_FILES["archivo"]["tmp_name"];
                //      move_uploaded_file($archivo, env('APP_PATH') . "/public/files/$nombre"); //guardaelarchivo
                //      $entidad->imagen = $nombre;
                //  }
      
      
                  //validaciones
                  if ($entidad->nombreproducto == "") {
                        
                      $msg["ESTADO"] = MSG_ERROR;
                      $msg["MSG"] = "Complete todos los datos";

                      $id = $entidad->idproducto;
                      $producto = new Producto();
                      $producto->obtenerPorId($id);
              
                      return view('sistema.producto-nuevo', compact('msg', 'producto', 'titulo', 'array_producto', 'array_producto_grupo')) . '?id=' . $producto->idproducto;
        
                  } else {
                        
                      if ($_POST["id"] > 0) {
                          //Es actualizacion
                          $entidad->guardar();
      
                          $msg["ESTADO"] = MSG_SUCCESS;
                          $msg["MSG"] = OKINSERT;

                        //   if($_FILES["archivo"]["error"] === UPLOAD_ERR_OK){
                        //     //Eliminar imagen anterior
                        //     @unlink(env('APP_PATH') . "/public/files/$productAnt->imagen");                          
                        // } else {
                        //     $entidad->imagen = $productAnt->imagen;
                        // }
    
                      } else {
                          //Es nuevo
                          $entidad->insertar();
      
                          $msg["ESTADO"] = MSG_SUCCESS;
                          $msg["MSG"] = OKINSERT;
                      }
                      
                      $_POST["id"] = $entidad->idproducto;
                      return view('sistema.producto-listar', compact('titulo', 'msg'));
                      $titulo="Listado de productos";
                  }
              } catch (Exception $e) {
                  $msg["ESTADO"] = MSG_ERROR;
                  $msg["MSG"] = ERRORINSERT;
              }
      
      
          }

          public function cargarGrilla()
          {
              $request = $_REQUEST;
      
              $entidad = new Producto();
              $aProducto = $entidad->obtenerFiltrado();
      
              $data = array();
              $cont = 0;
      
              $inicio = $request['start'];
              $registros_por_pagina = $request['length'];
      
      
              for ($i = $inicio; $i < count($aProducto) && $cont < $registros_por_pagina; $i++) {
                  $row = array();
                  $row[] = '<a href="/admin/producto/' . $aProducto[$i]->idproducto . '">' . $aProducto[$i]->nombreproducto . '</a>';
                  $row[] = $aProducto[$i]->cantidad;
                  $row[] = $aProducto[$i]->precio;
                  $row[] = $aProducto[$i]->fk_idtipoproducto;
                  $row[] = $aProducto[$i]->descripcion;
                  $row[] = $aProducto[$i]->imagen;

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
      
          public function editar($id){
            $titulo = "Edicion de producto";
            $producto= new Producto();
            $producto->obtenerPorId($id);

            $categoria = new Categoria();
            $array_categoria = $categoria->obtenerTodos();


            return view('sistema.producto-nuevo', compact('titulo','categoria', 'array_categoria', 'producto'));
        }
}