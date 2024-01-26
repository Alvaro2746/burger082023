<?php

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';
    public $timestamps = false;

    protected $fillable = [
      'idpedido',
      'total',
      'fk_idcarrito',
      'fk_idestado',
      'fecha',
      'metodo_pago',
      'fk_idsucursal',
      'fk_idcliente'

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
                  idpedido,
                  total,
                  fk_idcarrito,
                  fk_idestado,
                  fecha,
                  metodo_pago,
                  fk_idsucursal,
                  fk_idcliente
                FROM pedidos ORDER BY total";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }


    public function obtenerPorId($idpedido)
    {
        $sql = "SELECT
                idpedido,
                  total,
                  fk_idcarrito,
                  fk_idestado,
                  fecha,
                  metodo_pago,
                  fk_idsucursal,
                  fk_idcliente
                FROM pedidos WHERE idpedido = $idpedido";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idpedido = $lstRetorno[0]->idpedido;
            $this->total = $lstRetorno[0]->total;
            $this->fk_idcarrito = $lstRetorno[0]->fk_idcarrito;
            $this->fk_idestado = $lstRetorno[0]->fk_idestado;
            $this->fecha = $lstRetorno[0]->fecha;
            $this->metodo_pago = $lstRetorno[0]->metodo_pago;
            $this->fk_idsucursal = $lstRetorno[0]->fk_idsucursal;
            $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
            return $this;
        }
        return null;
    }

    
      public function guardar() {
          
            $sql = "UPDATE pedidos SET
                total='$this->total',
                fk_idcarrito='$this->fk_idcarrito',
                fk_idestado=$this->fk_idestado,
                fecha=$this->fecha,
                metodo_pago='$this->metodo_pago',
                fk_idsucursal='$this->fk_idsucursal',
                fk_idcliente='$this->fk_idcliente'
                WHERE idpedido=?";
            $affected = DB::update($sql, [$this->idpedido]);
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
                  fk_idcarrito,
                  fk_idestado,
                  fecha,
                  metodo_pago,
                  fk_idsucursal,
                  fk_idcliente
            ) VALUES (?, ?, ?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->total,
            $this->fk_idcarrito,
            $this->fk_idestado,
            $this->fecha,
            $this->metodo_pago,
            $this->fk_idsucursal,
            $this->fk_idcliente,
        ]);
        return $this->idpedido = DB::getPdo()->lastInsertId();
    }

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'P.total',
            1 => 'P.fk_idcarrito',
            2 => 'P.fk_idestado',
            3 => 'P.fecha',
            4 => 'P.metodo_pago',
            5 => 'P.fk_idsucursal',
            6 => 'P.fk_idcliente',
        );
        $sql = "SELECT 
                    P.idpedido,
                    P.total,
                    P.fk_idcarrito,
                    P.fk_idestado,
                    P.fecha,
                    P.fk_idsucursal,
                    P.metodo_pago,
                    P.fk_idcliente
                    FROM pedidos P
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( P.total LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR P.fk_idcarrito LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR P.fk_idestado LIKE '%" . $request['search']['value'] . "%' )";
            $sql .= " OR P.fecha LIKE '%" . $request['search']['value'] . "%' )";
            $sql .= " OR P.metodo_pago LIKE '%" . $request['search']['value'] . "%' )";
            $sql .= " OR P.fk_idsucursal LIKE '%" . $request['search']['value'] . "%' )";
            $sql .= " OR P.fk_idcliente LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }
    public function obtenerPorCliente($idcliente)
    {
        $sql = "SELECT
                  idpedido,
                  total,
                  fk_idcarrito,
                  fk_idestado,
                  fecha,
                  metodo_pago,
                  fk_idsucursal,
                  fk_idcliente
                FROM pedidos 
                WHERE fk_idcliente = $idcliente";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    
}
