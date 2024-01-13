<?php

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    public $timestamps = false;

    protected $fillable = [
        'idcliente', 'nombre', 'apellido', 'correo', 'telefono', 'dni', 'clave',
    ];

    protected $hidden = [

    ];

    public function cargarDesdeRequest($request) {
        $this->idcliente = $request->input('id') != "0" ? $request->input('id') : $this->idcliente;
        $this->nombre = $request->input('txtNombre');
        $this->apellido = $request->input('txtApellido');
        $this->correo = $request->input('txtCorreo') != "" ? $request->input('txtOrden') : 0;
        $this->telefono = $request->input('txtTelefono');
        $this->dni = $request->input('txtDni');
        $this->clave = $request->input('txtclave') != ""? password_hash(input('txtclave'), PASSWORD_DEFAULT): "";
    }

    

    public function obtenerTodos()
    {
        $sql = "SELECT
                  idcliente,
                  nombre,
                  apellido,
                  correo,
                  telefono,
                  dni,
                  clave
                FROM clientes ORDER BY nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }


    public function obtenerPorId($idcliente)
    {
        $sql = "SELECT
                idcliente,
                  nombre,
                  apellido,
                  correo,
                  telefono,
                  dni,
                  clave
                FROM clientes WHERE idcliente = $idcliente";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idcliente = $lstRetorno[0]->idcliente;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->apellido = $lstRetorno[0]->apellido;
            $this->correo = $lstRetorno[0]->correo;
            $this->telefono = $lstRetorno[0]->telefono;
            $this->dni = $lstRetorno[0]->dni;
            $this->clave = $lstRetorno[0]->clave;
            return $this;
        }
        return null;
    }

    
      public function guardar() {
            if ($this->clave != "")
    {
            $sql = "UPDATE clientes SET
                nombre='$this->nombre',
                apellido='$this->apellido',
                correo=$this->correo,
                telefono='$this->telefono',
                dni='$this->dni',
                clave='$this->clave'
                WHERE idcliente=?";
            $affected = DB::update($sql, [$this->idcliente]);
        }
        else
        {
            $sql = "UPDATE clientes SET
            nombre='$this->nombre',
            apellido='$this->apellido',
            correo=$this->correo,
            telefono='$this->telefono',
            dni='$this->dni',
            WHERE idcliente=?";
        $affected = DB::update($sql, [$this->idcliente]);
        }
    
    }

    public function eliminar()
    {
        $sql = "DELETE FROM clientes WHERE
            idcliente=?";
        $affected = DB::delete($sql, [$this->idcliente]);
    }

    public function insertar()
    {
        $sql = "INSERT INTO clientes (
                  nombre,
                  apellido,
                  correo,
                  telefono,
                  dni,
                  clave
            ) VALUES (?, ?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->nombre,
            $this->apellido,
            $this->correo,
            $this->telefono,
            $this->dni,
            $this->clave,
        ]);
        return $this->idcliente = DB::getPdo()->lastInsertId();
    }


}