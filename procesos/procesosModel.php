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

    function bajadetallecomite() {
        if ($_POST) {
            $sql = $this->_db->exec("DELETE FROM detallecomite WHERE detallecomite.detComId='" . $_POST['iddetalle'] . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function onecomite() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT comites.comId, comites.comFechaComite, comites.comHoraComite FROM comites WHERE comites.comId='" . $_POST['id'] . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function setagendacomite() {
        if ($_POST) {
            $sql = $this->_db->exec("UPDATE comites SET comites.comFechaComite='" . $_POST['txtFecha'] . "', comites.comHoraComite='" . $_POST['txtHora'] . "', comites.comEstado='Programado' WHERE comites.comId='" . $_POST['txtCodigo'] . "'");
            for ($i = 0; $i < count($_POST['txtInstructores']); $i++) {
                $comite = $this->_db->exec("INSERT INTO detallecomite(detComId, detComUsuario, detComComite) VALUES ('" . $_POST['txtAsistencia'][$i] . "','" . $_POST['txtInstructores'][$i] . "','" . $_POST['txtCodigo'] . "') "
                        . "ON DUPLICATE KEY UPDATE detComUsuario='" . $_POST['txtInstructores'][$i] . "', detComComite='" . $_POST['txtCodigo'] . "'");
            }
            return true;
        } else {
            return 0;
        }
    }

    function listainstructores() {
        if ($_POST) {
            $ficha = $this->_db->query("SELECT actas.actIdFicha FROM actas "
                    . "INNER JOIN comites ON actas.actId=comites.comIdActa "
                    . "WHERE comites.comId='" . $_POST['id'] . "'");
            $resficha = $ficha->fetchall();
            $sql = $this->_db->query("SELECT usuarios.usuId, usuarios.usuNombre, usuarios.usuApellido, usuarios.usuTipoDocu, usuarios.usuDocumento FROM usuarios "
                    . "INNER JOIN detalleaprendiz ON usuarios.usuId=detalleaprendiz.detIdAprendiz "
                    . "INNER JOIN roles ON usuarios.usuRol=roles.rolId "
                    . "INNER JOIN fichas ON detalleaprendiz.detIdFicha=fichas.fchaId "
                    . "WHERE fichas.fchaId='" . $resficha[0]['actIdFicha'] . "' AND roles.rolId='3'");
            $res = $sql->fetchall();
            $array = array();
            for ($i = 0; $i < count($res); $i++) {
                $e = array();
                $e['usuId'] = $res[$i]['usuId'];
                $e['usuNombre'] = $res[$i]['usuNombre'];
                $e['usuApellido'] = $res[$i]['usuApellido'];
                $e['usuTipoDocu'] = $res[$i]['usuTipoDocu'];
                $e['usuDocumento'] = $res[$i]['usuDocumento'];
                $comite = $this->_db->query("SELECT detallecomite.detComId FROM detallecomite "
                        . "WHERE detallecomite.detComUsuario='" . $res[$i]['usuId'] . "' AND detallecomite.detComComite='" . $_POST['id'] . "'");
                $rescomite = $comite->fetchall();
                if (count($rescomite) > 0) {
                    $e['estado'] = 'A';
                    $e['detComId'] = $rescomite[0]['detComId'];
                } else {
                    $e['detComId'] = '';
                    $e['estado'] = 'I';
                }
                array_push($array, $e);
            }
            return $array;
        } else {
            return 0;
        }
    }

    function listacomites() {
        date_default_timezone_set('America/Bogota');
        $ano = date('Y');
        $mes = date('m');
        $dia = date('d');
        $fecha = "$ano/$mes/$dia";
        $sql = $this->_db->query("SELECT comites.comId, comites.comFechaSolicitud, actas.actRuta, actas.actNumero, usuarios.usuNombre, usuarios.usuApellido, comites.comEstado, comites.comFechaComite, comites.comHoraComite FROM comites "
                . "INNER JOIN actas ON comites.comIdActa=actas.actId "
                . "INNER JOIN usuarios ON comites.comIdSolicitante=usuarios.usuId "
                . "ORDER BY comites.comFechaSolicitud DESC");
        $res = $sql->fetchall();
        $array = array();
        for ($i = 0; $i < count($res); $i++) {
            $e = array();
            $e['comId'] = $res[$i]['comId'];
            $e['comFechaSolicitud'] = $res[$i]['comFechaSolicitud'];
            $e['actRuta'] = $res[$i]['actRuta'];
            $e['actNumero'] = $res[$i]['actNumero'];
            $e['usuNombre'] = $res[$i]['usuNombre'];
            $e['usuApellido'] = $res[$i]['usuApellido'];
            if ($res[$i]['comEstado'] == 'Pendiente') {
                $e['comFechaComite'] = '';
                $e['comHoraComite'] = '';
            } else {
                $e['comFechaComite'] = $res[$i]['comFechaComite'];
                $e['comHoraComite'] = $res[$i]['comHoraComite'];
            }
            $ficha = $this->_db->query("SELECT actas.actIdFicha FROM actas "
                    . "INNER JOIN comites ON actas.actId=comites.comIdActa "
                    . "WHERE comites.comId='" . $res[$i]['comId'] . "'");
            $resficha = $ficha->fetchall();
            $usuarios = $this->_db->query("SELECT usuarios.usuNombre, usuarios.usuApellido, fichas.fchaNumero FROM detallecomite "
                    . "INNER JOIN usuarios ON detallecomite.detComUsuario=usuarios.usuId "
                    . "INNER JOIN detalleaprendiz ON usuarios.usuId=detalleaprendiz.detIdAprendiz "
                    . "INNER JOIN fichas ON detalleaprendiz.detIdFicha=fichas.fchaId "
                    . "WHERE detallecomite.detComComite='" . $res[$i]['comId'] . "' AND fichas.fchaId='" . $resficha[0]['actIdFicha'] . "' AND usuarios.usuRol='4'");
            $resusuarios = $usuarios->fetchall();
            $arrayusu = array();
            for ($j = 0; $j < count($resusuarios); $j++) {
                $e2 = array();
                $e2['aprendizusuNombre'] = $resusuarios[$j]['usuNombre'];
                $e2['aprendizusuApellido'] = $resusuarios[$j]['usuApellido'];
                $e2['fchaNumero'] = $resusuarios[$j]['fchaNumero'];
                array_push($arrayusu, $e2);
            }
            $e['aprendices'] = $arrayusu;
            $e['comEstado'] = $res[$i]['comEstado'];
            array_push($array, $e);
        }
        return $array;
    }

    function setcomite() {
        if ($_POST) {
            date_default_timezone_set('America/Bogota');
            $ano = date('Y');
            $mes = date('m');
            $dia = date('d');
            $fecha = "$ano/$mes/$dia";
            $usuario = Session::get('codigo');
            $sql = $this->_db->exec("INSERT INTO comites(comFechaSolicitud, comIdActa, comIdSolicitante, comEstado) "
                    . "VALUES ('" . $fecha . "','" . $_POST['txtActa'] . "','" . $usuario . "','Pendiente')");
            $id = $this->_db->lastInsertId();
            for ($i = 0; $i < count($_POST['txtAprendiz']); $i++) {
                $insert = $this->_db->exec("INSERT INTO detallecomite(detComUsuario, detComComite) VALUES "
                        . "('" . $_POST['txtAprendiz'][$i] . "','" . $id . "')");
            }
            return $sql;
        } else {
            return 0;
        }
    }

    function actadocumento() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT actas.actRuta FROM actas WHERE actas.actId='" . $_POST['acta'] . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function actascomite() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT actas.actId, actas.actNumero FROM actas WHERE actas.actIdFicha='" . $_POST['ficha'] . "' AND actas.actEstado='A'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function aprendicescomite() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT usuarios.usuId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido, usuarios.usuCorreo, usuarios.usuTelefono, fichas.fchaNumero FROM detalleaprendiz "
                    . "INNER JOIN usuarios ON detalleaprendiz.detIdAprendiz=usuarios.usuId "
                    . "INNER JOIN fichas ON detalleaprendiz.detIdFicha=fichas.fchaId "
                    . "INNER JOIN roles ON usuarios.usuRol=roles.rolId "
                    . "WHERE roles.rolNombre='Aprendiz' AND fichas.fchaId='" . $_POST['ficha'] . "' ORDER BY usuarios.usuNombre");
            $res = $sql->fetchall();
            return $res;
        } else {
            return 0;
        }
    }

    function setasistencia() {
        if ($_POST) {
            date_default_timezone_set('America/Bogota');
            $ano = date('Y');
            $mes = date('m');
            $dia = date('d');
            $fecha = "$ano/$mes/$dia";
            $hora = date('H:i:s');
            $usuario = Session::get('codigo');
            $validar = $this->_db->query("SELECT * FROM asistencia WHERE asistencia.asisFecha='" . $fecha . "' AND asistencia.asisFicha='" . $_POST['txtFichaCodigo'] . "'");
            $resvalida = $validar->fetchall();
            if (count($resvalida) > 0) {
                for ($i = 0; $i < count($_POST['txtAprendiz']); $i++) {
                    $datos = explode('-', $_POST['txtAprendiz'][$i]);
                    $aprendiz = $datos[0];
                    $estado = $datos[1];
                    $asistencia = $this->_db->exec("INSERT INTO detalleasistencia(detId, detIdAprendiz, detIdAsistencia, detEstado) VALUES "
                            . "('" . $_POST['txtIdAsistencia'][$i] . "','" . $aprendiz . "','" . $resvalida[0]['asisId'] . "','" . $estado . "') "
                            . "ON DUPLICATE KEY UPDATE detEstado='" . $estado . "'");
                }
                return true;
            } else {
                $sql = $this->_db->exec("INSERT INTO asistencia(asisFecha, asisHora, asisEncargado, asisFicha) VALUES ('" . $fecha . "','" . $hora . "','" . $usuario . "','" . $_POST['txtFichaCodigo'] . "')");
                $id = $this->_db->lastInsertId();
                for ($i = 0; $i < count($_POST['txtAprendiz']); $i++) {
                    $datos = explode('-', $_POST['txtAprendiz'][$i]);
                    $aprendiz = $datos[0];
                    $estado = $datos[1];
                    $asistencia = $this->_db->exec("INSERT INTO detalleasistencia(detIdAprendiz, detIdAsistencia, detEstado) VALUES "
                            . "('" . $aprendiz . "','" . $id . "','" . $estado . "')");
                }
                return $sql;
            }
        } else {
            return 0;
        }
    }

    function listaaprendicesinasistencia() {
        if ($_POST) {
            date_default_timezone_set('America/Bogota');
            $ano = date('Y');
            $mes = date('m');
            $dia = date('d');
            $fecha = "$ano/$mes/$dia";
            $sql = $this->_db->query("SELECT usuarios.usuId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido, usuarios.usuCorreo, usuarios.usuTelefono, fichas.fchaNumero FROM detalleaprendiz "
                    . "INNER JOIN usuarios ON detalleaprendiz.detIdAprendiz=usuarios.usuId "
                    . "INNER JOIN fichas ON detalleaprendiz.detIdFicha=fichas.fchaId "
                    . "INNER JOIN roles ON usuarios.usuRol=roles.rolId "
                    . "WHERE roles.rolNombre='Aprendiz' AND fichas.fchaId='" . $_POST['ficha'] . "' ORDER BY usuarios.usuNombre");
            $res = $sql->fetchall();
            $array = array();
            for ($i = 0; $i < count($res); $i++) {
                $e = array();
                $e['usuId'] = $res[$i]['usuId'];
                $e['usuTipoDocu'] = $res[$i]['usuTipoDocu'];
                $e['usuDocumento'] = $res[$i]['usuDocumento'];
                $e['usuNombre'] = $res[$i]['usuNombre'];
                $e['usuApellido'] = $res[$i]['usuApellido'];
                $e['usuCorreo'] = $res[$i]['usuCorreo'];
                $e['usuTelefono'] = $res[$i]['usuTelefono'];
                $e['fchaNumero'] = $res[$i]['fchaNumero'];
                $asis = $this->_db->query("SELECT detalleasistencia.detEstado, detalleasistencia.detId FROM detalleasistencia "
                        . "INNER JOIN asistencia ON detalleasistencia.detIdAsistencia=asistencia.asisId "
                        . "WHERE asistencia.asisFecha='" . $fecha . "' AND detalleasistencia.detIdAprendiz='" . $res[$i]['usuId'] . "'");
                $resasis = $asis->fetchall();
                if (count($resasis) > 0) {
                    $e['idasis'] = $resasis[0]['detId'];
                    $e['asistencia'] = $resasis[0]['detEstado'];
                } else {
                    $e['idasis'] = '';
                    $e['asistencia'] = '';
                }
                array_push($array, $e);
            }
            return $array;
        } else {
            return 0;
        }
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

    function listaaprendicesasignar() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT usuarios.usuId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido, usuarios.usuCorreo, usuarios.usuTelefono FROM usuarios "
                    . "INNER JOIN roles ON usuarios.usuRol=roles.rolId "
                    . "WHERE roles.rolNombre='Aprendiz' ORDER BY usuarios.usuNombre");
            $res = $sql->fetchall();
            $array = array();
            for ($i = 0; $i < count($res); $i++) {
                $e = array();
                $fichas = $this->_db->query("SELECT detalleaprendiz.detId, fichas.fchaNumero FROM detalleaprendiz "
                        . "INNER JOIN fichas ON detalleaprendiz.detIdFicha=fichas.fchaId "
                        . "INNER JOIN usuarios ON detalleaprendiz.detIdAprendiz=usuarios.usuId "
                        . "WHERE usuarios.usuId='" . $res[$i]['usuId'] . "' AND detalleaprendiz.detIdFicha='" . $_POST['ficha'] . "'");
                $resfichas = $fichas->fetchall();
                if (count($resfichas) > 0) {
                    
                } else {
                    $e['usuId'] = $res[$i]['usuId'];
                    $e['usuTipoDocu'] = $res[$i]['usuTipoDocu'];
                    $e['usuDocumento'] = $res[$i]['usuDocumento'];
                    $e['usuNombre'] = $res[$i]['usuNombre'];
                    $e['usuApellido'] = $res[$i]['usuApellido'];
                    $e['usuCorreo'] = $res[$i]['usuCorreo'];
                    $e['usuTelefono'] = $res[$i]['usuTelefono'];
                    array_push($array, $e);
                }
            }
            return $array;
        } else {
            return 0;
        }
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
