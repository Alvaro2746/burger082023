<?php

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    public $timestamps = false;

    protected $fillable = [
        'idproducto', 'nombreproducto', 'precio', 'fk_idtipoproducto', 'cantidad'
    ];

    protected $hidden = [

    ];

    public function cargarDesdeRequest($request) {
        $this->idproducto = $request->input('id') != "0" ? $request->input('id') : $this->idproducto;
        $this->nombreproducto = $request->input('txtNombreProducto');
        $this->precio = $request->input('txtPrecio');
        $this->fk_idtipoproducto = $request->input('txtCategoria');      
        $this->cantidad = $request->input('txtCantidad');
    }

    

    public function obtenerTodos()
    {
        $sql = "SELECT
                  idproducto,
                  nombreproducto,
                  precio,
                  fk_idtipoproducto,
                  cantidad
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
                  cantidad
                FROM productos WHERE idproducto = $idproducto";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idproducto = $lstRetorno[0]->idproducto;
            $this->nombreproducto = $lstRetorno[0]->nombreproducto;
            $this->precio = $lstRetorno[0]->precio;
            $this->fk_idtipoproducto = $lstRetorno[0]->fk_idtipoproducto;
            $this->cantidad = $lstRetorno[0]->cantidad;
            return $this;
        }
        return null;
    }

    
      public function guardar() {
            if ($this->clave != "")
    {
            $sql = "UPDATE productos SET
                nombreproducto='$this->nombreproducto',
                precio='$this->precio',
                fk_idtipoproducto=$this->fk_idtipoproducto,
                cantidad=$this->cantidad
                
                WHERE idproducto=?";
            $affected = DB::update($sql, [$this->idproducto]);
        }
        else
        {
            $sql = "UPDATE productos SET
            nombreproducto='$this->nombreproducto',
            precio='$this->precio',
            fk_idtipoproducto=$this->fk_idtipoproducto,
            cantidad=$this->cantidad
            
            WHERE idproducto=?";
        $affected = DB::update($sql, [$this->idproducto]);
        }
    
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
                  cantidad
            ) VALUES (?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->nombreproducto,
            $this->precio,
            $this->fk_idtipoproducto,
            $this->cantidad,
            
        ]);
        return $this->idproducto = DB::getPdo()->lastInsertId();
    }


}
