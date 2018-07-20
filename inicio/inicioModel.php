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

    function cantidadcomites() {
        $concomites = 0;
        $cantcomitesasignados = 0;
        $conplanes = 0;
        $conplanesasignados = 0;
        date_default_timezone_set('America/Bogota');
        $ano = date('Y');
        $mes = date('m');
        $dia = date('d');
        $fecha = "$ano/$mes/$dia";
        $usuarios = Session::get('codigo');
        $array = array();
        $e = array();
        if (Session::get('perfil') == 'Instructor') {
            $fichas = $this->_db->query("SELECT fichas.fchaId FROM fichas "
                    . "INNER JOIN detalleaprendiz ON fichas.fchaId=detalleaprendiz.detIdFicha "
                    . "INNER JOIN usuarios ON detalleaprendiz.detIdAprendiz=usuarios.usuId "
                    . "WHERE usuarios.usuId='" . $usuarios . "'");
            $resfichas = $fichas->fetchall();
            for ($i = 0; $i < count($resfichas); $i++) {
                $comites = $this->_db->query("SELECT comites.comId, comites.comFechaComite FROM comites "
                        . "WHERE comites.comIdFicha='" . $resfichas[$i]['fchaId'] . "' AND comites.comEstado='Programado' AND comites.comFechaComite>='" . $fecha . "'");
                $rescomites = $comites->fetchall();
                for ($j = 0; $j < count($rescomites); $j++) {
                    $fechacomite = $rescomites[$j]['comFechaComite'];
                    $nuevafecha = strtotime('+3 day', strtotime($fecha));
                    $nuevafecha = date('Y-m-j', $nuevafecha);
                    $fechacn = strtotime($fechacomite);
                    $fechaan = strtotime($nuevafecha);
                    if ($fechaan >= $fechacn) {
                        $concomites++;
                    }
                    $cantcomitesasignados++;
                }
                $planes = $this->_db->query("SELECT planmejoramiento.planId, planmejoramiento.planPlazoEntrega FROM planmejoramiento "
                        . "WHERE planmejoramiento.planIdFicha='" . $resfichas[$i]['fchaId'] . "' AND "
                        . "planmejoramiento.planSolicita='" . $usuarios . "' AND "
                        . "planmejoramiento.planEstado='Pendiente' AND "
                        . "planmejoramiento.planPlazoEntrega>='" . $fecha . "'");
                $resplanes = $planes->fetchall();
                for ($j = 0; $j < count($resplanes); $j++) {
                    $fechaplan = $resplanes[$j]['planPlazoEntrega'];
                    $nuevafechaplan = strtotime('+3 day', strtotime($fecha));
                    $nuevafechaplan = date('Y-m-j', $nuevafechaplan);
                    $fechapn = strtotime($fechaplan);
                    $fechapnue = strtotime($nuevafechaplan);
                    if ($fechapnue >= $fechapn) {
                        $conplanes++;
                    }
                    $conplanesasignados++;
                }
            }
            $e['porterminar'] = $concomites;
            $e['asignados'] = $cantcomitesasignados;
            $e['planesterminar'] = $conplanes;
            $e['planesasignados'] = $conplanesasignados;
            array_push($array, $e);
        } else {
            $comites = $this->_db->query("SELECT comites.comId, comites.comFechaComite FROM comites "
                    . "WHERE comites.comEstado='Programado' AND comites.comFechaComite>='" . $fecha . "'");
            $rescomites = $comites->fetchall();
            for ($j = 0; $j < count($rescomites); $j++) {
                $fechacomite = $rescomites[$j]['comFechaComite'];
                $nuevafecha = strtotime('+3 day', strtotime($fecha));
                $nuevafecha = date('Y-m-j', $nuevafecha);
                $fechacn = strtotime($fechacomite);
                $fechaan = strtotime($nuevafecha);
                if ($fechaan >= $fechacn) {
                    $concomites++;
                }
                $cantcomitesasignados++;
            }
            $planes = $this->_db->query("SELECT planmejoramiento.planId, planmejoramiento.planPlazoEntrega FROM planmejoramiento "
                    . "WHERE planmejoramiento.planEstado='Pendiente' AND "
                    . "planmejoramiento.planPlazoEntrega>='" . $fecha . "'");
            $resplanes = $planes->fetchall();
            for ($j = 0; $j < count($resplanes); $j++) {
                $fechaplan = $resplanes[$j]['planPlazoEntrega'];
                $nuevafechaplan = strtotime('+3 day', strtotime($fecha));
                $nuevafechaplan = date('Y-m-j', $nuevafechaplan);
                $fechapn = strtotime($fechaplan);
                $fechapnue = strtotime($nuevafechaplan);
                if ($fechapnue >= $fechapn) {
                    $conplanes++;
                }
                $conplanesasignados++;
            }
            $e['porterminar'] = $concomites;
            $e['asignados'] = $cantcomitesasignados;
            $e['planesterminar'] = $conplanes;
            $e['planesasignados'] = $conplanesasignados;
            array_push($array, $e);
        }
        return $array;
    }

    function setpassword() {
        if ($_POST) {
            if ($_POST['password'] == $_POST['confirmPassword']) {
                $usuario = Session::get('codigo');
                $sql = $this->_db->exec("UPDATE usuarios SET usuarios.usuPassword='" . md5($_POST['confirmPassword']) . "' WHERE usuarios.usuId='" . $usuario . "'");
                return $sql;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    function validapassword() {
        if ($_POST) {
            $usuario = Session::get('codigo');
            $sql = $this->_db->prepare("SELECT usuarios.usuId FROM usuarios "
                    . "WHERE usuarios.usuId=? AND usuarios.usuPassword=?");
            $sql->execute(array($usuario, md5($_POST['password'])));
            $res = $sql->fetchall();
            return $res;
        } else {
            return 0;
        }
    }

    function updatedatos() {
        if ($_POST) {
            $sql = $this->_db->exec("UPDATE usuarios SET usuarios.usuTipoDocu='" . $_POST['txtTipo'] . "', usuarios.usuDocumento='" . $_POST['txtDocumento'] . "', usuarios.usuNombre='" . $_POST['txtNombre'] . "', usuarios.usuApellido='" . $_POST['txtApellido'] . "', usuarios.usuCorreo='" . $_POST['txtCorreo'] . "', usuarios.usuTelefono='" . $_POST['txtTelefono'] . "' "
                    . "WHERE usuarios.usuId='" . $_POST['txtCodigo'] . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function onedatos() {
        $sql = $this->_db->query("SELECT usuarios.usuId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido, usuarios.usuCorreo, usuarios.usuTelefono FROM usuarios "
                . "WHERE usuarios.usuId='" . Session::get('codigo') . "'");
        return $sql->fetchall();
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
