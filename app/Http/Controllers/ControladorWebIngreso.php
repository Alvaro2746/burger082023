<?php

namespace App\Http\Controllers;

// use Adldap\Laravel\Facades\Adldap;
use App\Entidades\Sistema\Cliente;
use Illuminate\Http\Request;
use Session;

require app_path() . '/start/constants.php';
require app_path() . '/start/funciones_generales.php';

class ControladorWebIngreso extends Controller{
    public function index(Request $request)
    {
        $titulo = 'Acceso';
        return view('web.ingreso', compact('titulo'));
    }

    public function login(Request $request)
      {
            return view("web.index");
      }

    public function logout(Request $request)
    {
        Session::flush();
        return view("web.index");
      }

    public function entrar(Request $request){

        $correoIngresado = fescape_string($request->input('txtCorreo'));
        $claveIngresada = fescape_string($request->input('txtClave'));

        $cliente = new Cliente();
        $lstCliente = $cliente->validarCorreo($correoIngresado);


        if (count($lstCliente) > 0) {
            if (password_verify($claveIngresada, $lstCliente[0]->clave)) {
                $titulo = 'Inicio';
                $request->session()->put('cliente_id', $lstCliente[0]->idcliente);
                $request->session()->put('correo', $lstCliente[0]->correo);
                $request->session()->put('dni', $lstCliente[0]->dni);
                $request->session()->put('telefono', $lstCliente[0]->telefono);
                $request->session()->put('cliente_nombre', $lstCliente[0]->nombre . " " . $lstCliente[0]->apellido);


                //Carga los grupos de cuentas de cliente

                //Grupo predeterminado
                return view('web.index', compact('titulo'));
            } else {
                $titulo = 'Acceso denegado';
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Credenciales incorrectas";
                return view('web.ingreso', compact('titulo', 'msg'));
            }
        } else {
            $titulo = 'Acceso denegado';
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = "Credenciales incorrectas";
            return view('web.ingreso', compact('titulo', 'msg'));
        }
    }
    public function cerrar(){
        $titulo = 'Acceso';

        session()->put('cliente_id', "");
        session()->put('correo', "");
        session()->put('cliente_nombre', "");

        return view('web.ingreso',compact('titulo'));

}

}
