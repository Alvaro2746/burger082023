<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Producto;
use App\Entidades\Sistema\Categoria;
use Illuminate\Support\Facades\Storage;

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




public function storeFile(Request $req)
{
    
    
    $request->validate([
        'archivo' => 'required|mimes:png,jpg,jpeg|max:2048', // Validación del tipo y tamaño del archivo
    ]);

    // Obtiene el archivo cargado
    $archivo = $request->file('archivo');
    $name = date("Ymdhmsi");

    // Almacena el archivo en el disco local
    $ruta = $archivo->storeAs('archivos', $name.$archivo->getClientOriginalName(),'public');
    
}



      public function guardar(Request $request)
      {
        
        // $request->validate([
        //     'archivo' => 'required|mimes:png,jpg,jpeg|max:2048', // Validación del tipo y tamaño del archivo
        // ]);
    
        // // Obtiene el archivo cargado
        // $archivo = $request->file('archivo');
        // $name = date("Ymdhmsi");
    
        // // Almacena el archivo en el disco local
        // $ruta = $archivo->storeAs('archivos', $name.$archivo->getClientOriginalName(),'public');

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
                        if (isset($producto) && file_exists(env('APP_PATH') . "/public/files/$producto->imagen")) {
                            unlink(env('APP_PATH') . "/public/files/$producto->imagen");
                        // }
                    }
                
        
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
              } }}catch (Exception $e) {
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
                $rutaImagen = storage_path("app\public\archivos\\{$aProducto[$i]->imagen}");

                  $row = array();
                  $row[] = '<a href="/admin/producto/' . $aProducto[$i]->idproducto . '">' . $aProducto[$i]->nombreproducto . '</a>';
                  $row[] = $aProducto[$i]->cantidad;
                  $row[] = $aProducto[$i]->precio;
                  $row[] = $aProducto[$i]->fk_idtipoproducto;
                  $row[] = $aProducto[$i]->descripcion;
                  $row[] = $row[] = '<img src="'.$rutaImagen.'" alt="" class="">';

                  

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