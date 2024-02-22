<?php

namespace App\Http\Controllers;

use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Producto;
use Session;

class ControladorWebCarrito extends Controller
{
    public function index()
    {
        if (session('correo') ==! null){
            return view("web.carrito");

        }else{
            $titulo = 'Acceso';
            return view('web.ingreso',compact('titulo'));

        }
    }
}
