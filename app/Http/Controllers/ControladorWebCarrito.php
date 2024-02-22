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
            return view("web.carrito");
    }
}
