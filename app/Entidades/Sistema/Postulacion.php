<?php

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

class Postulacion extends Model
{
    protected $table = '';
    public $timestamps = false;

    protected $fillable = [
        'idpostulacion', 'nombre', 'apellido', 'email', 'domicilio', 'whatsapp', 'cv',
    ];

    protected $hidden = [

    ];

    public function cargarDesdeRequest($request) {
        $this->idpostulacion = $request->input('id') != "0" ? $request->input('id') : $this->idcliente;
        $this->nombre = $request->input('txtNombre');
        $this->apellido = $request->input('txtApellido');
        $this->email = $request->input('txtEmail');
        $this->domicilio = $request->input('txtDomicilio');
        $this->whatsapp = $request->input('txtWhatsapp');
    }

    

    public function obtenerTodos()
    {
        $sql = "SELECT
                  idpostulacion,
                  nombre,
                  apellido,
                  email,
                  domicilio,
                  whatsapp
                FROM postulaciones ORDER BY nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }


    public function obtenerPorId($idpostulacion)
    {
        $sql = "SELECT
                  idpostulacion,
                  nombre,
                  apellido,
                  email,
                  domicilio,
                  whatsapp                
                  FROM postulaciones WHERE idpostulacion = $idpostulacion";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idpostulacion = $lstRetorno[0]->idpostulacion;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->apellido = $lstRetorno[0]->apellido;
            $this->email = $lstRetorno[0]->correo;
            $this->domicilio = $lstRetorno[0]->telefono;
            $this->whatsapp = $lstRetorno[0]->dni;
            return $this;
        }
        return null;
    }

    
      public function guardar() {
            $sql = "UPDATE postulaciones SET
                nombre='$this->nombre',
                apellido='$this->apellido',
                email=$this->email,
                domicilio='$this->domicilio',
                whatsapp='$this->whatsapp'
                WHERE idpostulacion=?";
            $affected = DB::update($sql, [$this->idpostulacion]);
       
    
    }

    public function eliminar()
    {
        $sql = "DELETE FROM postulaciones WHERE
            idpostulacion=?";
        $affected = DB::delete($sql, [$this->idpostulacion]);
    }

    public function insertar()
    {
        $sql = "INSERT INTO postulaciones (
                  nombre,
                  apellido,
                  email,
                  domicilio,
                  whatsapp                
            ) VALUES (?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->nombre,
            $this->apellido,
            $this->email,
            $this->domicilio,
            $this->whatsapp,
        ]);
        return $this->idcliente = DB::getPdo()->lastInsertId();
    }


}
