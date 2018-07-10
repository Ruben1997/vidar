<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of inicioModel
 *
 * @author RUBEN DARIO
 */
class inicioModel extends Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function setlogin() {
        if ($_POST) {
            $sql = $this->_db->prepare("SELECT usuarios.usuId, usuarios.usuNombre, usuarios.usuApellido, roles.rolNombre FROM usuarios "
                    . "INNER JOIN roles ON usuarios.usuRol=roles.rolId "
                    . "WHERE usuarios.usuCorreo=? AND usuarios.usuPassword=?");
            $sql->execute(array($_POST['txtCorreo'], md5($_POST['txtPassword'])));
            $res = $sql->fetchall();
            if (count($res) > 0) {
                Session::set('codigo', $res[0]['usuId']);
                Session::set('autenticado', true);
                Session::set('usuario', ucwords(strtolower($res[0]['usuNombre'] . ' ' . $res[0]['usuApellido'])));
                Session::set('perfil', $res[0]['rolNombre']);
            } else {
                Session::set('codigo', '');
                Session::set('autenticado', false);
                Session::set('usuario', '');
                Session::set('perfil', '');
            }
        } else {
            return 0;
        }
    }

    function registro() {
        if ($_POST) {
            $sql = $this->_db->exec("INSERT INTO usuarios(usuTipoDocu, usuDocumento, usuNombre, usuApellido, usuCorreo, usuTelefono, usuPassword) "
                    . "VALUES ('" . $_POST['txtTipo'] . "','" . $_POST['txtDocumento'] . "','" . $_POST['txtNombre'] . "','" . $_POST['txtApellido'] . "','" . $_POST['txtCorreo'] . "','" . $_POST['txtTelefono'] . "','" . md5($_POST['confirmPassword']) . "')");
            return $sql;
        } else {
            return 0;
        }
    }

}
