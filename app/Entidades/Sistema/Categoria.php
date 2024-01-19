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
        $this->nombrecategoria = $request->input('txtNombrecategoria');
        
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
            $this->idtipoproducto = $lstRetorno[0]->idtipoproductos;
            $this->nombrecategoria = $lstRetorno[0]->nombrecategoria;
            
            return $this;
        }
        return null;
    }

    
      public function guardar() {
            if ($this->clave != "")
    {
            $sql = "UPDATE tipoproductos SET
                nombrecategoria='$this->nombre'

                WHERE idtipoproductos=?";
            $affected = DB::update($sql, [$this->idtipoproductos]);
        }
        else
        {
            $sql = "UPDATE tipoproductos SET
            nombrecategoria='$this->nombrecategoria'
            WHERE idtipoproductos=?";
        $affected = DB::update($sql, [$this->idtipoproductos]);
        }
    
    }

    public function eliminar()
    {
        $sql = "DELETE FROM tipoproductos WHERE
            idtipoproductos=?";
        $affected = DB::delete($sql, [$this->idtipoproductos]);
    }

    public function insertar()
    {
        $sql = "INSERT INTO tipoproductos (
                  nombrecategoria
            ) VALUES (?);";
        $result = DB::insert($sql, [
            $this->nombrecategoria,
        ]);
        return $this->idtipoproductos = DB::getPdo()->lastInsertId();
    }


}
