<?php

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'Pedidos';
    public $timestamps = false;

    protected $fillable = [
        'idpedido', 'total', 'fecha', 'metodo_pago', 'fk_idcliente', 'fk_idsucursal', 'fk_idestado'
    ];

    protected $hidden = [

    ];

   

    

    public function obtenerTodos()
    {
        $sql = "SELECT
                  idpedido,
                  total,
                  fecha, 
                  metodo_pago, 
                  fk_idcliente, 
                  fk_idsucursal, 
                  fk_idestado
                FROM pedidos ORDER BY total";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }


    public function obtenerPorId($idpedido)
    {
        $sql = "SELECT
                idpedido,
                  total,
                  fecha, 
                  metodo_pago, 
                  fk_idcliente, 
                  fk_idsucursal, 
                  fk_idestado
                FROM pedidos WHERE idpedido = $idpedido";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idpedido = $lstRetorno[0]->idpedido;
            $this->total = $lstRetorno[0]->total;
            $this->fecha = $lstRetorno[0]->fecha;
            $this->metodo_pago = $lstRetorno[0]->metodo_pago;
            $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
            $this->fk_idsucursal = $lstRetorno[0]->fk_idsucursal;
            $this->fk_idestado = $lstRetorno[0]->fk_idestado;
            
            return $this;
        }
        return null;
    }

    
      public function guardar() {
            if ($this->clave != "")
    {
            $sql = "UPDATE pedidos SET
                total='$this->total',
                fecha='$this->totfechaal',
                metodo_pago='$this->metodo_pago',
                fk_idcliente='$this->fk_idcliente',
                fk_idsucursal='$this->fk_idsucursal',
                fk_idestado='$this->fk_idestado',
                
                WHERE idpedido=?";
            $affected = DB::update($sql, [$this->idpedido]);
        }
        else
        {
            $sql = "UPDATE pedidos SET
                total='$this->total',
                fecha='$this->totfechaal',
                metodo_pago='$this->metodo_pago',
                fk_idcliente='$this->fk_idcliente',
                fk_idsucursal='$this->fk_idsucursal',
                fk_idestado='$this->fk_idestado',
            WHERE idpedido=?";
        $affected = DB::update($sql, [$this->idpedido]);
        }
    
    }

    public function eliminar()
    {
        $sql = "DELETE FROM pedidos WHERE
            idpedido=?";
        $affected = DB::delete($sql, [$this->idpedido]);
    }

    public function insertar()
    {
        $sql = "INSERT INTO pedidos (
                  total,
                  fecha, 
                  metodo_pago, 
                  fk_idcliente, 
                  fk_idsucursal, 
                  fk_idestado

            ) VALUES (?);";
        $result = DB::insert($sql, [
            $this->total,
        ]);
        return $this->idpedido = DB::getPdo()->lastInsertId();
    }


}
