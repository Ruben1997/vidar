<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of procesosModel
 *
 * @author Ruben1997
 */
class procesosModel extends Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function updaterol() {
        if ($_POST) {
            $sql = $this->_db->exec("UPDATE usuarios SET usuarios.usuRol='".$_POST['txtRol']."' WHERE usuarios.usuId='".$_POST['txtCodigo']."'");
            return $sql;
        } else {
            return 0;
        }
    }

    function listarroles() {
        $sql = $this->_db->query("SELECT roles.rolId, roles.rolNombre FROM roles WHERE roles.rolEstado='A'");
        return $sql->fetchall();
    }

    function autorizausuarios() {
        $sql = $this->_db->query("SELECT usuarios.usuId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido, usuarios.usuCorreo, usuarios.usuTelefono FROM usuarios WHERE usuarios.usuRol = '' OR usuarios.usuRol IS NULL");
        return $sql->fetchall();
    }

}
