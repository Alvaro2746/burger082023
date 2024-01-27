<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Producto;
use App\Entidades\Sistema\Categoria;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use Illuminate\Support\Facades\Storage;

require app_path().'/start/constants.php';

class ControladorProducto extends Controller
{
      public function nuevo()
      {
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("PRODUCTOCONSULTA")) {
                $codigo = "PRODUCTOCONSULTA";
                $mensaje = "No tiene permisos para la operación.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $titulo = "Nuevo Producto";

                $categoria = new Categoria();
                $array_categoria = $categoria->obtenerTodos();
    
                //  print_r($array_categoria);
                //  exit;
                
                return view('sistema.producto-nuevo', compact('titulo', 'categoria', 'array_categoria' ));
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
                $titulo = "Listado de Productos";
                return view('sistema.Producto-listar', compact('titulo'));
                }
        } else {
            return redirect('admin/login');
        }


      }








      public function guardar(Request $request)
      {
            try {
                  //Define la entidad servicio
                  $titulo = "Modificar Producto";
                  $entidad = new Producto();
                  $entidad->cargarDesdeRequest($request);



                  if (isset($_FILES["archivo"]) && $_FILES["archivo"]["error"] === UPLOAD_ERR_OK) {
                    
                    $nombreAleatorio = date("Ymdhmsi") . rand(1000, 2000); //202210202002371010
                    $archivo_tmp = $_FILES["archivo"]["tmp_name"];
                    $extension = strtolower(pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION));

                    if ($extension == "jpg" || $extension == "jpeg" || $extension == "png") {
                        $nombre = "$nombreAleatorio.$extension";
                        $archivo = $_FILES["archivo"]["tmp_name"];

                        move_uploaded_file($archivo, env('APP_PATH') . "/public/files/$nombre");
                        $entidad -> imagen = $nombre;
        
                        //Eliminar la imagen anterior
                        
                    
                    }
                }else{
                    $id = $entidad->idproducto;
                    $producto = new Producto();
                    $producto->obtenerPorId($id);

                    $entidad -> imagen = $producto->imagen;
                }
                
                    
                  //validaciones
                  if ($entidad->nombreproducto == "") {
                        
                      $msg["ESTADO"] = MSG_ERROR;
                      $msg["MSG"] = "Complete todos los datos";

                      
    
                      return view('sistema.producto-nuevo', compact('msg', 'producto', 'titulo', 'array_producto', 'array_producto_grupo')) . '?id=' . $producto->idproducto;
                  } else {
                        
                      if ($_POST["id"] > 0) {
                          //Es actualizacion
                          $id = $entidad->idproducto;
                          $producto = new Producto();
                          $producto->obtenerPorId($id);



                        if(isset($_FILES["archivo"]) && $_FILES["archivo"]["error"] === UPLOAD_ERR_OK)
                        {
                            
                            @unlink(env('APP_PATH') . "/public/files/$producto->imagen");                          
                        }
                          $entidad->guardar();

                          $msg["ESTADO"] = MSG_SUCCESS;
                          $msg["MSG"] = OKINSERT;
    
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
               }catch (Exception $e) {
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
                  $row[] = '<img src="'.'/files/'.$aProducto[$i]->imagen.'" alt="Imagen del producto" class="img-thumbnail"></img>';
                   
                //$row[] = '<img src="'.$aProducto[$i]->imagen.'" alt="" class="">';                
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


            if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("PRODUCTOEDITAR")) {
                $codigo = "PRODUCTOEDITAR";
                $mensaje = "No tiene permisos para la operación.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $producto= new Producto();
                $producto->obtenerPorId($id);
    
                $categoria = new Categoria();
                $array_categoria = $categoria->obtenerTodos();
    
                return view('sistema.producto-nuevo', compact('titulo','categoria', 'array_categoria', 'producto'));
                }
        } else {
            return redirect('admin/login');
        }


        }
        public function eliminar(Request $request)
        {

            if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("PRODUCTOELIMINAR	")) {
                $codigo = "PRODUCTOELIMINAR	";
                $mensaje = "No tiene permisos para la operación.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $id = $request->input('id');
    
    
                $entidad = new Producto();
                $entidad->cargarDesdeRequest($request);
                
                $id = $entidad->idproducto;
                $producto = new Producto();
                $producto->obtenerPorId($id);
                
                $entidad->eliminar();
                $data["err"]=0;
                return json_encode($data);                    
                if(isset($producto->imagen))
                {
                    @unlink(env('APP_PATH') . "/public/files/$producto->imagen");                          
                }
                return view('sistema.producto-listar', compact('producto'));
        }
        } else {
            return redirect('admin/login');
        }

        }


}