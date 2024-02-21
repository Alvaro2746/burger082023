<?php

namespace App\Http\Controllers;

use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Producto;
use Session;

class ControladorWebContacto extends Controller
{
    public function index()
    {
            return view("web.contacto");
    }
}
