<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of parametrosModel
 *
 * @author Ruben1997
 */
class parametrosModel extends Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function tablaaprendices() {
        if ($_POST) {
            if ((isset($_POST["ficha"]) && isset($_POST["programa"]) && isset($_POST["institucion"])) && ($_POST["ficha"] != "" || $_POST["programa"] != "" || $_POST["institucion"] != "")) {
                $sql = "SELECT usuarios.usuId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido, usuarios.usuCorreo, usuarios.usuTelefono, fichas.fchaNumero FROM detalleaprendiz "
                        . "RIGHT JOIN usuarios ON detalleaprendiz.detIdAprendiz=usuarios.usuId "
                        . "LEFT JOIN fichas ON detalleaprendiz.detIdFicha=fichas.fchaId "
                        . "INNER JOIN roles ON usuarios.usuRol=roles.rolId "
                        . "WHERE ";
                if (!empty($_POST['ficha'])) {
                    $sql .= "fichas.fchaId='" . $_POST['ficha'] . "' ";
                }
                if (!empty($_POST['programa'])) {
                    if (!empty($_POST['ficha'])) {
                        $sql .= "AND ";
                    }
                    $sql .= "fichas.fchaIdPrograma='" . $_POST['programa'] . "' ";
                }
                if (!empty($_POST['institucion'])) {
                    if (!empty($_POST['ficha']) || !empty($_POST['programa'])) {
                        $sql .= "AND ";
                    }
                    $sql .= "fichas.fchaIdInstitucion='" . $_POST['institucion'] . "'";
                }

                $sql .= "AND roles.rolNombre='Aprendiz' ORDER BY usuarios.usuNombre";
            } else {
                $sql = "SELECT usuarios.usuId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido, usuarios.usuCorreo, usuarios.usuTelefono, fichas.fchaNumero FROM detalleaprendiz "
                        . "RIGHT JOIN usuarios ON detalleaprendiz.detIdAprendiz=usuarios.usuId "
                        . "LEFT JOIN fichas ON detalleaprendiz.detIdFicha=fichas.fchaId "
                        . "INNER JOIN roles ON usuarios.usuRol=roles.rolId "
                        . "WHERE roles.rolNombre='Aprendiz' ORDER BY usuarios.usuNombre";
            }
            $datos = $this->_db->query($sql);
            return $datos->fetchall();
        } else {
            return 0;
        }
    }

    function cargaficha() {
        if ($_POST) {
            if (!empty($_POST['institucion']) && !empty($_POST['programa'])) {
                $sql = $this->_db->query("SELECT fichas.fchaId, fichas.fchaNumero FROM fichas "
                        . "WHERE fichas.fchaIdPrograma='" . $_POST['programa'] . "' AND fichas.fchaIdInstitucion='" . $_POST['institucion'] . "' AND fichas.fchaEstado='A'");
            } else if (!empty($_POST['institucion']) && empty($_POST['programa'])) {
                $sql = $this->_db->query("SELECT fichas.fchaId, fichas.fchaNumero FROM fichas "
                        . "WHERE fichas.fchaIdInstitucion='" . $_POST['institucion'] . "' AND fichas.fchaEstado='A'");
            } else if (!empty($_POST['programa']) && empty($_POST['institucion'])) {
                $sql = $this->_db->query("SELECT fichas.fchaId, fichas.fchaNumero FROM fichas "
                        . "WHERE fichas.fchaIdPrograma='" . $_POST['programa'] . "' AND fichas.fchaEstado='A'");
            }
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function oneusuario() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT usuarios.usuId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido, usuarios.usuCorreo, usuarios.usuTelefono FROM usuarios "
                    . "WHERE usuarios.usuId='" . $_POST['id'] . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function setaprendiz() {
        if ($_POST) {
            $rol = $this->_db->query("SELECT roles.rolId FROM roles WHERE roles.rolNombre='Aprendiz'");
            $res = $rol->fetchall();
            $sql = $this->_db->exec("INSERT INTO usuarios(usuId, usuTipoDocu, usuDocumento, usuNombre, usuApellido, usuCorreo, usuTelefono, usuRol) "
                    . "VALUES ('" . $_POST['txtCodigo'] . "','" . $_POST['txtTipo'] . "','" . $_POST['txtDocumento'] . "','" . $_POST['txtNombre'] . "','" . $_POST['txtApellido'] . "','" . $_POST['txtCorreo'] . "','" . $_POST['txtTelefono'] . "','" . $res[0]['rolId'] . "') "
                    . "ON DUPLICATE KEY UPDATE usuTipoDocu='" . $_POST['txtTipo'] . "', usuDocumento='" . $_POST['txtDocumento'] . "', usuNombre='" . $_POST['txtNombre'] . "', usuApellido='" . $_POST['txtApellido'] . "', usuCorreo='" . $_POST['txtCorreo'] . "', usuTelefono='" . $_POST['txtTelefono'] . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function bajaaprendices($arg) {
        if ($arg) {
            $sql = $this->_db->exec("DELETE FROM usuarios WHERE usuarios.usuId='" . $arg . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function aprendices() {
        $sql = $this->_db->query("SELECT usuarios.usuId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido, usuarios.usuCorreo, usuarios.usuTelefono, fichas.fchaNumero FROM detalleaprendiz "
                . "RIGHT JOIN usuarios ON detalleaprendiz.detIdAprendiz=usuarios.usuId "
                . "LEFT JOIN fichas ON detalleaprendiz.detIdFicha=fichas.fchaId "
                . "INNER JOIN roles ON usuarios.usuRol=roles.rolId "
                . "WHERE roles.rolNombre='Aprendiz' ORDER BY usuarios.usuNombre");
        return $sql->fetchall();
    }

    function bajafichas($arg = false) {
        if ($arg) {
            $sql = $this->_db->exec("UPDATE fichas SET fichas.fchaEstado='I' WHERE fichas.fchaId='" . $arg . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function setficha() {
        if ($_POST) {
            $sql = $this->_db->exec("INSERT INTO fichas(fchaId, fchaNumero, fchaIdPrograma, fchaIdInstitucion, fchaEstado) "
                    . "VALUES ('" . $_POST['txtCodigo'] . "','" . $_POST['txtNumero'] . "','" . $_POST['txtPrograma'] . "','" . $_POST['txtInstitucion'] . "','A') "
                    . "ON DUPLICATE KEY UPDATE fchaNumero='" . $_POST['txtNumero'] . "', fchaIdPrograma='" . $_POST['txtPrograma'] . "', fchaIdInstitucion='" . $_POST['txtInstitucion'] . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function oneficha() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT fichas.fchaId, fichas.fchaNumero, fichas.fchaIdPrograma, fichas.fchaIdInstitucion FROM fichas "
                    . "WHERE fichas.fchaId='" . $_POST['id'] . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function fichas() {
        $sql = $this->_db->query("SELECT fichas.fchaId, fichas.fchaNumero, programas.proNombre, instituciones.instNombre FROM fichas "
                . "INNER JOIN programas ON fichas.fchaIdPrograma=programas.proId "
                . "INNER JOIN instituciones ON fichas.fchaIdInstitucion=instituciones.instId "
                . "WHERE fichas.fchaEstado='A'");
        return $sql->fetchall();
    }

    function bajaprogramas($arg = false) {
        if ($arg) {
            $sql = $this->_db->exec("UPDATE programas SET programas.proEstado='I' WHERE programas.proId='" . $arg . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function setprograma() {
        if ($_POST) {
            $sql = $this->_db->exec("INSERT INTO programas (proId, proNombre, proEstado) "
                    . "VALUES ('" . $_POST['txtCodigo'] . "','" . $_POST['txtNombre'] . "','A') "
                    . "ON DUPLICATE KEY UPDATE proNombre='" . $_POST['txtNombre'] . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function oneprograma() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT programas.proId, programas.proNombre FROM programas WHERE programas.proId='" . $_POST['id'] . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function programas() {
        $sql = $this->_db->query("SELECT programas.proId, programas.proNombre FROM programas WHERE programas.proEstado='A'");
        return $sql->fetchall();
    }

    function bajainstituciones($arg = false) {
        if ($arg) {
            $sql = $this->_db->exec("UPDATE instituciones SET instituciones.instEstado='I' WHERE instituciones.instId='" . $arg . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function setinstitucion() {
        if ($_POST) {
            $sql = $this->_db->exec("INSERT INTO instituciones(instId, instNombre, instDireccion, instNit, instCiudad, instEstado) "
                    . "VALUES ('" . $_POST['txtCodigo'] . "','" . $_POST['txtNombre'] . "','" . $_POST['txtDireccion'] . "','" . $_POST['txtNit'] . "','" . $_POST['txtCiudad'] . "','A') "
                    . "ON DUPLICATE KEY UPDATE instNombre='" . $_POST['txtNombre'] . "', instDireccion='" . $_POST['txtDireccion'] . "', instNit='" . $_POST['txtNit'] . "', instCiudad='" . $_POST['txtCiudad'] . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function instituciones() {
        $sql = $this->_db->query("SELECT instituciones.instId, instituciones.instNombre, instituciones.instDireccion, ciudad.ciudad, estado.estadonombre, pais.paisnombre, instituciones.instNit FROM instituciones "
                . "INNER JOIN ciudad ON instituciones.instCiudad=ciudad.id INNER JOIN estado ON ciudad.estado=estado.id "
                . "INNER JOIN pais ON estado.ubicacionpaisid=pais.id "
                . "WHERE instituciones.instEstado='A' ORDER BY instituciones.instNombre");
        return $sql->fetchall();
    }

    function oneinstitucion() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT instituciones.instId, instituciones.instNombre, instituciones.instDireccion, instituciones.instNit, instituciones.instCiudad, estado.id as est, pais.id as pa FROM instituciones "
                    . "INNER JOIN ciudad ON instituciones.instCiudad=ciudad.id "
                    . "INNER JOIN estado ON ciudad.estado=estado.id "
                    . "INNER JOIN pais ON estado.ubicacionpaisid=pais.id "
                    . "WHERE instituciones.instId='" . $_POST['id'] . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function oneestado($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT estado.id, estado.estadonombre FROM estado "
                    . "WHERE estado.ubicacionpaisid='" . $arg . "' ORDER BY estado.estadonombre");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function oneciudad($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT ciudad.id, ciudad.ciudad FROM ciudad WHERE ciudad.estado='" . $arg . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function paises() {
        $sql = $this->_db->query("SELECT pais.id, pais.paisnombre FROM pais ORDER BY pais.paisnombre");
        return $sql->fetchall();
    }

}
