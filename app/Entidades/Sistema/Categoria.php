<?php

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'tipoproductos';
    public $timestamps = false;

    protected $fillable = [
        'idtipoproducto', 'nombrecategoria',
    ];

    protected $hidden = [

    ];

    public function cargarDesdeRequest($request) {
        $this->idtipoproducto = $request->input('id') != "0" ? $request->input('id') : $this->idtipoproducto;
        $this->nombrecategoria = $request->input('txtNombre');
        
    }

    

    public function obtenerTodos()
    {
        $sql = "SELECT
                  idtipoproducto,
                  nombrecategoria
                FROM tipoproductos ORDER BY nombrecategoria";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }


    public function obtenerPorId($idtipoproducto)
    {
        $sql = "SELECT
            idtipoproducto,
            nombrecategoria
            FROM tipoproductos WHERE idtipoproducto = $idtipoproducto";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idtipoproducto = $lstRetorno[0]->idtipoproducto;
            $this->nombrecategoria = $lstRetorno[0]->nombrecategoria;
            
            return $this;
        }
        return null;
    }

    
      public function guardar() {
 
            $sql = "UPDATE tipoproductos SET
            nombrecategoria='$this->nombrecategoria'
            WHERE idtipoproducto=?";
        $affected = DB::update($sql, [$this->idtipoproducto]);
        
    
    }

    public function eliminar()
    {
        $sql = "DELETE FROM tipoproductos WHERE
            idtipoproducto=?";
        $affected = DB::delete($sql, [$this->idtipoproducto]);
    }

    public function insertar()
    {
        $sql = "INSERT INTO tipoproductos (
                  nombrecategoria
            ) VALUES (?);";
        $result = DB::insert($sql, [
            $this->nombrecategoria,
        ]);
        return $this->idtipoproducto = DB::getPdo()->lastInsertId();
    }
    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'T.nombrecategoria',

        );
        $sql = "SELECT 
                    T.idtipoproducto,
                    T.nombrecategoria
                    FROM tipoproductos T
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( T.nombrecategoria LIKE '%" . $request['search']['value'] . "%' ";

        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }


}
