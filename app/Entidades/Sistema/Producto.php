<?php

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    public $timestamps = false;

    protected $fillable = [
        'idproducto', 'nombreproducto', 'precio', 'fk_idtipoproducto', 'cantidad', 'descripcion', 'imagen'
    ];

    protected $hidden = [

    ];

    public function cargarDesdeRequest($request) {
        // $this->archivo = $request->input('archivo');

    

        $this->idproducto = $request->input('id') != "0" ? $request->input('id') : $this->idproducto;
        $this->nombreproducto = $request->input('txtNombreProducto');
        $this->precio = $request->input('txtPrecio');
        $this->fk_idtipoproducto = $request->input('txtCategoria');      
        $this->cantidad = $request->input('txtCantidad');
        $this->descripcion = $request->input('txtDescripcion');
        // $this->imagen = date("Ymdhmsi").$request->input('archivo');
    }

    public function mostrarImagen($rutaArchivo)
    {
        return response()->file(storage_path("app/archivos/{$this->imagen}"));
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                  idproducto,
                  nombreproducto,
                  precio,
                  fk_idtipoproducto,
                  cantidad,
                  descripcion,
                  imagen
                FROM productos ORDER BY nombreproducto";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }


    public function obtenerPorId($idproducto)
    {
        $sql = "SELECT
                  idproducto,
                  nombreproducto,
                  precio,
                  fk_idtipoproducto,
                  cantidad,
                  descripcion,
                  imagen                
                  FROM productos WHERE idproducto = $idproducto";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idproducto = $lstRetorno[0]->idproducto;
            $this->nombreproducto = $lstRetorno[0]->nombreproducto;
            $this->precio = $lstRetorno[0]->precio;
            $this->fk_idtipoproducto = $lstRetorno[0]->fk_idtipoproducto;
            $this->cantidad = $lstRetorno[0]->cantidad;
            $this->descripcion = $lstRetorno[0]->descripcion;
            $this->imagen = $lstRetorno[0]->imagen;
            return $this;
        }
        return null;
    }



    
      public function guardar() {
            
            $sql = "UPDATE productos SET
                nombreproducto='$this->nombreproducto',
                precio='$this->precio',
                fk_idtipoproducto='$this->fk_idtipoproducto',
                cantidad='$this->cantidad',
                descripcion='$this->descripcion',
                imagen='$this->imagen'
                
                WHERE idproducto=?";
            $affected = DB::update($sql, [$this->idproducto]);
        }
       
    
    

    public function eliminar()
    {
        $sql = "DELETE FROM productos WHERE
            idproducto=?";
        $affected = DB::delete($sql, [$this->idproducto]);
    }

    public function insertar()
    {


        $sql = "INSERT INTO productos (
                  nombreproducto,
                  precio,
                  fk_idtipoproducto,
                  cantidad,
                  descripcion,
                  imagen  
            ) VALUES (?, ?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->nombreproducto,
            $this->precio,
            $this->fk_idtipoproducto,
            $this->cantidad,
            $this->descripcion,
            $this->imagen
            
        ]);
        return $this->idproducto = DB::getPdo()->lastInsertId();
    }

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'P.nombreproducto',
            1 => 'P.cantidad',
            2 => 'P.precio',
            3 => 'P.fk_idtipoproducto',
            4 => 'P.descripcion',
            5 => 'P.imagen',
        );
        $sql = "SELECT 
                    P.idproducto,
                    P.nombreproducto,
                    P.cantidad,
                    P.precio,
                    P.fk_idtipoproducto,
                    P.descripcion,
                    P.imagen
                    FROM productos P
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( P.nombreproducto LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR P.cantidad LIKE '%" . $request['search']['value'] . "%' )";
            $sql .= " OR P.precio LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR P.fk_idtipoproducto LIKE '%" . $request['search']['value'] . "%' )";
            $sql .= " OR P.descripcion LIKE '%" . $request['search']['value'] . "%' )";
            $sql .= " OR P.imagen LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }



}
