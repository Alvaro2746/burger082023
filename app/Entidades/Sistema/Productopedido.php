<?php

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

class Productopedido extends Model
{
    protected $table = 'productos_pedidos';
    public $timestamps = false;

    protected $fillable = [
      'idproductopedido',
      'fk_idproducto',
      'fk_idpedido',
      'precio_unitario',
      'cantidad',
      'total'

    ];

    protected $hidden = [

    ];

//     public function cargarDesdeRequest($request) {
//         $this->idpedido = $request->input('id') != "0" ? $request->input('id') : $this->idpedido;
//         $this->total = $request->input('txtNombre');
//         $this->fk_idcarrito = $request->input('txtApellido');
//         $this->fk_idestado = $request->input('txtCorreo');
//         $this->metodo_pago = $request->input('txtTelefono');
//         $this->fk_idsucursal = $request->input('txtDNI');
//         $this->fk_idcliente = $request->input('txtDNI');
//     }

    

    public function obtenerTodos()
    {
        $sql = "SELECT
      idproductopedido,
      fk_idproducto,
      fk_idpedido,
      precio_unitario,
      cantidad,
      total
                FROM productos_pedidos ORDER BY fk_idpedido";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }


    public function obtenerPorId($idproductopedido)
    {
        $sql = "SELECT
        idproductopedido,
        fk_idproducto,
        fk_idpedido,
        precio_unitario,
        cantidad,
        total
                FROM productos_pedidos WHERE idproductopedido = $idproductopedido";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idproductopedido = $lstRetorno[0]->idproductopedido;
            $this->fk_idproducto = $lstRetorno[0]->fk_idproducto;
            $this->fk_idpedido = $lstRetorno[0]->fk_idpedido;
            $this->precio_unitario = $lstRetorno[0]->precio_unitario;
            $this->cantidad = $lstRetorno[0]->cantidad;
            $this->total = $lstRetorno[0]->total;

            return $this;
        }
        return null;
    }

    
      public function guardar() {
          
            $sql = "UPDATE productos_pedidos SET
                fk_idproducto='$this->fk_idproducto',
                fk_idpedido='$this->fk_idpedido',
                precio_unitario=$this->precio_unitario,
                cantidad=$this->cantidad,
                total='$this->total'
                WHERE idproductopedido=?";
            $affected = DB::update($sql, [$this->idpedido]);
        }
     
    
    

    public function eliminar()
    {
        $sql = "DELETE FROM productos_pedidos WHERE
            idproductopedido=?";
        $affected = DB::delete($sql, [$this->idpedido]);
    }

    public function insertar()
    {
        $sql = "INSERT INTO pedidos (
        fk_idproducto,
        fk_idpedido,
        precio_unitario,
        cantidad,
        total
            ) VALUES (?, ?, ?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->fk_idpedido,
            $this->precio_unitario,
            $this->cantidad,
            $this->total,
        ]);
        return $this->idpedido = DB::getPdo()->lastInsertId();
    }

  
    public function obtenerTodosPorPedido($fk_idpedido)
    {
        $sql = "SELECT
      idproductopedido,
      fk_idproducto,
      fk_idpedido,
      precio_unitario,
      cantidad,
      total
                FROM productos_pedidos 
                WHERE fk_idpedido = $fk_idpedido";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
      }


    
}
