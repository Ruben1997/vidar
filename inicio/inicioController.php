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
    
    public function cerrarsesion(){
        Session::destroy();
        $this->redireccionar('inicio/index');
    }

    public function portal() {
        @$layout = $this->layout($_POST['val']);
        $this->_view->titulo = 'Portal';
        $this->_view->metodo = "Portal";
        $this->_view->metodoaccion = 'Inicio';
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
        @$layout = $this->layout($_POST['val']);
        $this->_view->titulo = 'Login Usuario';
        $this->_view->metodo = "Inicio";
        $this->_view->metodoaccion = 'Iniciar Sesion';
        $this->_view->renderizar('inicio', 'vidar', $layout);
    }

    public function registrarse() {
        @$layout = $this->layout($_POST['val']);
        $this->_view->titulo = 'Formulario Registro';
        $this->_view->metodo = "Inicio";
        $this->_view->metodoaccion = 'Registro Usuarios';
        $this->_view->renderizar('registro', 'vidar', $layout);
    }

}
