<?php

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'estados';
    public $timestamps = false;

    protected $fillable = [
        'idestado', 'nombre_estado'
    ];

    protected $hidden = [

    ];


    public function obtenerTodos()
    {
        $sql = "SELECT
                  E.idestado,
                  E.nombre
                FROM estados E ORDER BY E.nombre_estado";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }


}
