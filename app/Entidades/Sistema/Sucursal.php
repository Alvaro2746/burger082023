<?php

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $table = 'sucursales';
    public $timestamps = false;

    protected $fillable = [
        'idsucursal', 'nombresucursal','direccionsucursal', 'estado_sucursal'
    ];

    protected $hidden = [

    ];

    public function cargarDesdeRequest($request) {
        $this->idsucursal = $request->input('id') != "0" ? $request->input('id') : $this->idsucursal;
        $this->nombresucursal = $request->input('txtNombre');
        $this->direccionsucursal = $request->input('txDireccion');
        $this->estado_sucursal = $request->input('txtEstado');
        
    }

    

    public function obtenerTodos()
    {
        $sql = "SELECT
                  idsucursal,
                  nombresucursal,
                  direccionsucursal,
                  estado_sucursal
                FROM sucursales ORDER BY nombresucursal";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }





    public function obtenerPorId($idsucursal)
    {
        $sql = "SELECT
            idsucursal,
            nombresucursal,
            direccionsucursal,
            estado_sucursal
            FROM sucursales WHERE idsucursal = $idsucursal";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idsucursal = $lstRetorno[0]->idsucursal;
            $this->nombresucursal = $lstRetorno[0]->nombresucursal;
            $this->direccionsucursal = $lstRetorno[0]->direccionsucursal;
            $this->estado_sucursal = $lstRetorno[0]->estado_sucursal;
            
            return $this;
        }
        return null;
    }

    
      public function guardar() {
            $sql = "UPDATE sucursales SET
                nombresucursal='$this->nombresucursal',
                direccionsucursal='$this->direccionsucursal',
                estado_sucursal='$this->estado_sucursal'


                WHERE idsucursal=?";
            $affected = DB::update($sql, [$this->idsucursal]);
        }
        

    public function eliminar()
    {
        $sql = "DELETE FROM sucursales WHERE
            idsucursal=?";
        $affected = DB::delete($sql, [$this->idsucursal]);
    }

    public function insertar()
    {
        $sql = "INSERT INTO sucursales (
                  nombresucursal,
                  direccionsucursal,
                  estado_sucursal
            ) VALUES (?, ?, ?);";
        $result = DB::insert($sql, [
            $this->nombresucursal,
            $this->direccionsucursal,
            $this->estado_sucursal
        ]);
        return $this->idsucursal = DB::getPdo()->lastInsertId();
    }
    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'S.nombresucursal',
            1 => 'S.direccionsucursal',
            2 => 'S.estado_sucursal',

        );
        $sql = "SELECT 
                    S.idsucursal,
                    S.nombresucursal,
                    S.direccionsucursal,
                    S.estado_sucursal
                    FROM sucursales S
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( S.nombresucursal LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR S.direccionsucursal LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR S.estado_sucursal LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }


}
