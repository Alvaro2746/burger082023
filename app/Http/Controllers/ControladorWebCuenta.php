<?php

namespace App\Http\Controllers;

use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Cliente;
use App\Entidades\Sistema\Producto;
use Session;

class ControladorWebCuenta extends Controller
{
    public function index()
    {
        if (session('correo') ==! null){
            $cliente = new Cliente();
            
            return view("web.cuenta");

        }else{
            $titulo = 'Acceso';
            return view('web.ingreso',compact('titulo'));

        }
    }
}
