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

    function insertaraprendices($usuarios = false) {
        if ($usuarios) {
            for ($i = 0; $i < count($usuarios); $i++) {
                $val = $this->_db->query("SELECT usuarios.usuId FROM usuarios WHERE usuarios.usuDocumento='" . $usuarios[$i]['documento'] . "'");
                $res = $val->fetchall();
                if (count($res) > 0) {
                    $ficha = $this->_db->query("SELECT * FROM detalleaprendiz WHERE detalleaprendiz.detIdAprendiz='" . $res[0]['usuId'] . "' AND detalleaprendiz.detIdFicha='" . $_POST['txtFicha'] . "'");
                    $resficha = $ficha->fetchall();
                    if (count($resficha) > 0) {
                        
                    } else {
                        $aprendices = $this->_db->exec("INSERT INTO detalleaprendiz(detIdAprendiz, detIdFicha) VALUES ('" . $res[0]['usuId'] . "','" . $_POST['txtFicha'] . "')");
                    }
                } else {
                    $rol = $this->_db->query("SELECT roles.rolId FROM roles WHERE roles.rolNombre='Aprendiz'");
                    $resrol = $rol->fetchall();
                    $sql = $this->_db->exec("INSERT INTO usuarios(usuTipoDocu, usuDocumento, usuNombre, usuApellido, usuCorreo, usuTelefono, usuRol) VALUES "
                            . "('" . $usuarios[$i]['tipo'] . "','" . $usuarios[$i]['documento'] . "','" . $usuarios[$i]['nombre'] . "','" . $usuarios[$i]['apellido'] . "','" . $usuarios[$i]['correo'] . "','" . $usuarios[$i]['telefono'] . "','" . $resrol[0]['rolId'] . "')");
                    $id = $this->_db->lastInsertId();
                    $aprendicesinsert = $this->_db->exec("INSERT INTO detalleaprendiz(detIdAprendiz, detIdFicha) VALUES ('" . $id . "','" . $_POST['txtFicha'] . "')");
                }
            }
            return true;
        } else {
            return 0;
        }
    }

    function setficha() {
        if ($_POST) {
            for ($i = 0; $i < count($_POST['txtAprendiz']); $i++) {
                $sql = $this->_db->exec("INSERT INTO detalleaprendiz (detalleaprendiz.detIdAprendiz, detalleaprendiz.detIdFicha) VALUES "
                        . "('" . $_POST['txtAprendiz'][$i] . "','" . $_POST['txtFicha'] . "')");
            }
            return $sql;
        } else {
            return 0;
        }
    }

    function listaaprendices() {
        $sql = $this->_db->query("SELECT usuarios.usuId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido, usuarios.usuCorreo, usuarios.usuTelefono, fichas.fchaNumero FROM detalleaprendiz "
                . "RIGHT JOIN usuarios ON detalleaprendiz.detIdAprendiz=usuarios.usuId "
                . "LEFT JOIN fichas ON detalleaprendiz.detIdFicha=fichas.fchaId "
                . "INNER JOIN roles ON usuarios.usuRol=roles.rolId "
                . "WHERE roles.rolNombre='Aprendiz' AND fichas.fchaNumero IS NULL ORDER BY usuarios.usuNombre");
        return $sql->fetchall();
    }

    function updaterol() {
        if ($_POST) {
            $sql = $this->_db->exec("UPDATE usuarios SET usuarios.usuRol='" . $_POST['txtRol'] . "' WHERE usuarios.usuId='" . $_POST['txtCodigo'] . "'");
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
