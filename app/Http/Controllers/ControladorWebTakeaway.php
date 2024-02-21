<?php

namespace App\Http\Controllers;

use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Producto;
use Session;

class ControladorWebTakeaway extends Controller
{
    public function index()
    {
        $producto= new Producto();
        $viewProductos = $producto->obtenerTodos(); 

            return view("web.takeaway", compact('viewProductos'));
    }
}
