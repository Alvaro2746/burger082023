<?php

namespace App\Http\Controllers;

class ControladorSucursal extends Controller
{
      public function nuevo()
      {
            $titulo = "Nueva sucursal";
            return view('sistema.sucursal-nuevo', compact('titulo'));
      }
}