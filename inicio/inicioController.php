<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of inicioController
 *
 * @author RUBEN DARIO
 */
class inicioController extends Controller {

    //put your code here
    public function __construct() {
        parent::__construct("inicio");
    }

    public function cerrarsesion() {
        Session::destroy();
        $this->redireccionar('inicio/index');
    }

    public function setpassword() {
        $data = $this->loadModel('inicio');
        $sql = $data->setpassword();
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('inicio/editcuenta');
        exit();
    }

    public function validateaccountuser() {
        $data = $this->loadModel('inicio');
        $datos = $data->validapassword();
        if (count($datos) > 0) {
            $this->_view->datos = $data->onedatos();
            $this->_view->response = 1;
        } else {
            $this->_view->response = 2;
        }
        $this->_view->renderizar('formulariocuenta', 'blank');
    }

    public function updatedatosusuario() {
        $data = $this->loadModel('inicio');
        $sql = $data->updatedatos();
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('inicio/editdatos');
        exit();
    }

    public function validateuserdatos() {
        $data = $this->loadModel('inicio');
        $datos = $data->validapassword();
        if (count($datos) > 0) {
            $this->_view->datos = $data->onedatos();
            $this->_view->response = 1;
        } else {
            $this->_view->response = 2;
        }
        $this->_view->renderizar('formulariodatos', 'blank');
    }

    public function editdatos() {
        $data = $this->loadModel('inicio');
        @$layout = $this->layout($_POST['val']);
        $this->_view->titulo = 'Editar Datos';
        $this->_view->metodo = "Cuenta";
        $this->_view->metodoaccion = 'Editar Datos';
        $this->_view->renderizar('datosusuario', 'vidar', $layout);
    }

    public function editcuenta() {
        $data = $this->loadModel('inicio');
        @$layout = $this->layout($_POST['val']);
        $this->_view->titulo = 'Editar Cuenta';
        $this->_view->metodo = "Cuenta";
        $this->_view->metodoaccion = 'Editar Cuenta';
        $this->_view->renderizar('cuenta', 'vidar', $layout);
    }

    public function portal() {
        $data = $this->loadModel('inicio');
        @$layout = $this->layout($_POST['val']);
        $this->_view->titulo = 'Portal';
        $this->_view->metodo = "Portal";
        $this->_view->metodoaccion = 'Inicio';
        $cantidad = $data->cantidadcomites();
        $this->_view->cantcomites = $cantidad;
        $this->_view->renderizar('portal', 'vidar', $layout);
    }

    public function setlogin() {
        $data = $this->loadModel('inicio');
        $sql = $data->setlogin();
        if (Session::get('autenticado')) {
            if (isset($_POST['txtRecordarme'])) {
                $dominio = $_SERVER["HTTP_HOST"];
                setcookie("user", $_POST['txtCorreo'], time() + 3600, "/", $dominio);
                setcookie("pass", $_POST['txtPassword'], time() + 3600, "/", $dominio);
            } else {
                setcookie("user", "", time() - 3600, "/");
                setcookie("pass", "", time() - 3600, "/");
            }
            $perfil = Session::get('perfil');
            if (!empty($perfil)) {
                Session::set('mensaje', 'Bienvenido ' . Session::get('usuario'));
                Session::set('tipomensaje', 'alert-success');
                $this->redireccionar('inicio/portal');
            } else {
                Session::set('mensaje', 'Usuario no autorizado');
                Session::set('tipomensaje', 'alert-danger');
                $this->cerrarsesion();
            }
        } else {
            Session::set('mensaje', 'Error, verifique sus datos');
            Session::set('tipomensaje', 'alert-danger');
            $this->redireccionar('inicio/index');
        }
        exit();
    }

    public function guardardatos() {
        $data = $this->loadModel('inicio');
        $sql = $data->registro();
        if ($sql) {
            Session::set('mensaje', 'Usuario registrado correctamente');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('inicio/index');
        exit();
    }

    public function index() {
        if (Session::get('autenticado')) {
            $this->redireccionar('inicio/portal');
        } else {
            @$layout = $this->layout($_POST['val']);
            $this->_view->titulo = 'Login Usuario';
            $this->_view->metodo = "Inicio";
            $this->_view->metodoaccion = 'Iniciar Sesion';
            $this->_view->renderizar('inicio', 'vidar', $layout);
        }
    }

    public function registrarse() {
        @$layout = $this->layout($_POST['val']);
        $this->_view->titulo = 'Formulario Registro';
        $this->_view->metodo = "Inicio";
        $this->_view->metodoaccion = 'Registro Usuarios';
        $this->_view->renderizar('registro', 'vidar', $layout);
    }

}
