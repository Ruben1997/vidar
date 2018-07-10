<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of procesosController
 *
 * @author Ruben1997
 */
class procesosController extends Controller {

    //put your code here
    public function __construct() {
        parent::__construct("procesos");
    }

    public function setrol() {
        $data = $this->loadModel('procesos');
        $sql = $data->updaterol();
        if ($sql) {
            Session::set('mensaje', 'Usuario autorizado correctamente');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('procesos/autorizarusuario');
        exit();
    }

    public function modalroles() {
        $data = $this->loadModel('procesos');
        $this->_view->roles = $data->listarroles();
        $this->_view->id = $_POST['id'];
        $this->_view->renderizar('asignarRoles', 'blank');
    }

    public function autorizarusuario() {
        $data = $this->loadModel('procesos');
        $this->_view->usuarios = $data->autorizausuarios();
        $layout = $this->layout($_POST['val']);
        $this->_view->titulo = 'Autorizar Usuarios';
        $this->_view->metodo = "Procesos";
        $this->_view->metodoaccion = 'Autorizar Usuarios';
        $this->_view->renderizar('autorizarUsuarios', 'vidar', $layout);
    }

}
