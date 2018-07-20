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

    function setnovedad() {
        if ($_POST) {
            date_default_timezone_set('America/Bogota');
            $ano = date('Y');
            $mes = date('m');
            $dia = date('d');
            $fecha = "$ano/$mes/$dia";
            $hora = date('H:i:s');
            $sql = $this->_db->exec("INSERT INTO registranovedades(rnovDescripcion, rnovFecha, rnovHora, rnovIdNovedad, rnovTipo, rnovFicha) "
                    . "VALUES ('" . $_POST['txtDescripcionNovedad'] . "','" . $fecha . "','" . $hora . "','" . $_POST['txtNovedad'][0] . "','" . $_POST['txtTipoNovedad'] . "','".$_POST['txtCodigoFicha']."')");
            $id = $this->_db->lastInsertId();
            for ($i = 0; $i < count($_POST['txtAprendiz']); $i++) {
                $detalle = $this->_db->exec("INSERT INTO detallenovedad(dnovAprendiz, dnovIdNovedad) VALUES ('" . $_POST['txtAprendiz'][$i] . "','" . $id . "')");
            }
            return $sql;
        } else {
            return 0;
        }
    }

    function onenovedades() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT novedadespredefinidas.novpId, novedadespredefinidas.novpNovedad, deberesreglamento.debDescripcion FROM novedadespredefinidas "
                    . "INNER JOIN deberesreglamento ON novedadespredefinidas.novpIdDeber=deberesreglamento.debId "
                    . "WHERE novedadespredefinidas.novpTipo='" . $_POST['tipo'] . "' AND novedadespredefinidas.novpEstado='A' ORDER BY novedadespredefinidas.novpNovedad");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function usuariosnovedades() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT usuarios.usuId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido FROM usuarios "
                    . "INNER JOIN detalleaprendiz ON usuarios.usuId=detalleaprendiz.detIdAprendiz "
                    . "INNER JOIN fichas ON detalleaprendiz.detIdFicha=fichas.fchaId "
                    . "INNER JOIN roles ON usuarios.usuRol=roles.rolId "
                    . "WHERE roles.rolNombre='Aprendiz' AND fichas.fchaId='" . $_POST['id'] . "' "
                    . "GROUP BY usuarios.usuId ORDER BY usuarios.usuNombre");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function filtraplanesmejoramiento() {
        if ($_POST) {
            date_default_timezone_set('America/Bogota');
            $ano = date('Y');
            $mes = date('m');
            $dia = date('d');
            $fecha = "$ano/$mes/$dia";
            $sql = $this->_db->query("SELECT planmejoramiento.planId, planmejoramiento.planFecha, planmejoramiento.planPlazoEntrega, planmejoramiento.planDescripcionActividad, usuarios.usuNombre, usuarios.usuApellido, planmejoramiento.planEstado FROM planmejoramiento "
                    . "INNER JOIN usuarios ON planmejoramiento.planSolicita=usuarios.usuId "
                    . "WHERE planmejoramiento.planPlazoEntrega>='" . $fecha . "' AND planmejoramiento.planIdFicha='" . $_POST['id'] . "'");
            $res = $sql->fetchall();
            $array = array();
            for ($j = 0; $j < count($res); $j++) {
                $e = array();
                $datos = $this->_db->query("SELECT usuarios.usuNombre, usuarios.usuApellido FROM usuarios "
                        . "INNER JOIN detalleplanmejoramiento ON usuarios.usuId=detalleplanmejoramiento.detIdAprendiz "
                        . "INNER JOIN planmejoramiento ON detalleplanmejoramiento.detIdPlan=planmejoramiento.planId "
                        . "WHERE planmejoramiento.planId='" . $res[$j]['planId'] . "'");
                $resdatos = $datos->fetchall();
                $e['planId'] = $res[$j]['planId'];
                $e['planFecha'] = $res[$j]['planFecha'];
                $e['planPlazoEntrega'] = $res[$j]['planPlazoEntrega'];
                $e['planDescripcionActividad'] = $res[$j]['planDescripcionActividad'];
                $e['usuNombre'] = $res[$j]['usuNombre'];
                $e['usuApellido'] = $res[$j]['usuApellido'];
                $e['planEstado'] = $res[$j]['planEstado'];
                $array2 = array();
                for ($k = 0; $k < count($resdatos); $k++) {
                    $e2 = array();
                    $e2['usuNombre'] = $resdatos[$k]['usuNombre'];
                    $e2['usuApellido'] = $resdatos[$k]['usuApellido'];
                    array_push($array2, $e2);
                }
                $e['aprendices'] = $array2;
                array_push($array, $e);
            }
            return $array;
        } else {
            return 0;
        }
    }

    function detalleplan() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT planmejoramiento.planEstado, planmejoramiento.planFecha, planmejoramiento.planId, planmejoramiento.planPlazoEntrega, planmejoramiento.planDescripcionActividad, instituciones.instId, programas.proId, fichas.fchaId FROM planmejoramiento "
                    . "INNER JOIN fichas ON planmejoramiento.planIdFicha=fichas.fchaId "
                    . "INNER JOIN instituciones ON fichas.fchaIdInstitucion=instituciones.instId "
                    . "INNER JOIN programas ON fichas.fchaIdPrograma=programas.proId "
                    . "WHERE planmejoramiento.planId='" . $_POST['id'] . "'");
            $res = $sql->fetchall();
            $array = array();
            for ($i = 0; $i < count($res); $i++) {
                $e = array();
                $e['planId'] = $res[$i]['planId'];
                $e['planPlazoEntrega'] = $res[$i]['planPlazoEntrega'];
                $e['planDescripcionActividad'] = $res[$i]['planDescripcionActividad'];
                $e['instId'] = $res[$i]['instId'];
                $e['proId'] = $res[$i]['proId'];
                $e['fchaId'] = $res[$i]['fchaId'];
                $e['planFecha'] = $res[$i]['planFecha'];
                $e['planEstado'] = $res[$i]['planEstado'];
                $aprendices = $this->_db->query("SELECT usuarios.usuId, detalleplanmejoramiento.detPlanId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido, detalleplanmejoramiento.detPlanNota FROM usuarios "
                        . "INNER JOIN detalleplanmejoramiento ON usuarios.usuId=detalleplanmejoramiento.detIdAprendiz "
                        . "INNER JOIN planmejoramiento ON detalleplanmejoramiento.detIdPlan=planmejoramiento.planId "
                        . "WHERE planmejoramiento.planId='" . $res[$i]['planId'] . "'");
                $resaprendices = $aprendices->fetchall();
                $array2 = array();
                for ($j = 0; $j < count($resaprendices); $j++) {
                    $e2 = array();
                    $e2['usuId'] = $resaprendices[$j]['usuId'];
                    $e2['detPlanId'] = $resaprendices[$j]['detPlanId'];
                    $e2['usuTipoDocu'] = $resaprendices[$j]['usuTipoDocu'];
                    $e2['usuDocumento'] = $resaprendices[$j]['usuDocumento'];
                    $e2['usuNombre'] = $resaprendices[$j]['usuNombre'];
                    $e2['usuApellido'] = $resaprendices[$j]['usuApellido'];
                    if (!empty($resaprendices[$j]['detPlanNota'])) {
                        $e2['detPlanNota'] = $resaprendices[$j]['detPlanNota'];
                    } else {
                        $e2['detPlanNota'] = '';
                    }
                    array_push($array2, $e2);
                }
                $e['aprendices'] = $array2;
                array_push($array, $e);
            }
            return $array;
        }
    }

    function setcalificacion() {
        if ($_POST) {
            $sql = $this->_db->exec("UPDATE planmejoramiento SET planmejoramiento.planEstado='Entregado' WHERE planmejoramiento.planId='" . $_POST['txtCodigo'] . "'");
            for ($i = 0; $i < count($_POST['txtNota']); $i++) {
                $nota = explode('-', $_POST['txtNota'][$i]);
                $plan = $nota[0];
                $aprobo = $nota[1];
                $detalle = $this->_db->exec("UPDATE detalleplanmejoramiento SET detalleplanmejoramiento.detPlanNota='" . $aprobo . "' WHERE detalleplanmejoramiento.detPlanId='" . $plan . "'");
            }
            return $sql;
        } else {
            return 0;
        }
    }

    function datoscalificarplan() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT planmejoramiento.planId, planmejoramiento.planPlazoEntrega, planmejoramiento.planDescripcionActividad, instituciones.instId, programas.proId, fichas.fchaId FROM planmejoramiento "
                    . "INNER JOIN fichas ON planmejoramiento.planIdFicha=fichas.fchaId "
                    . "INNER JOIN instituciones ON fichas.fchaIdInstitucion=instituciones.instId "
                    . "INNER JOIN programas ON fichas.fchaIdPrograma=programas.proId "
                    . "WHERE planmejoramiento.planId='" . $_POST['id'] . "'");
            $res = $sql->fetchall();
            $array = array();
            for ($i = 0; $i < count($res); $i++) {
                $e = array();
                $e['planId'] = $res[$i]['planId'];
                $e['planPlazoEntrega'] = $res[$i]['planPlazoEntrega'];
                $e['planDescripcionActividad'] = $res[$i]['planDescripcionActividad'];
                $e['instId'] = $res[$i]['instId'];
                $e['proId'] = $res[$i]['proId'];
                $e['fchaId'] = $res[$i]['fchaId'];
                $aprendices = $this->_db->query("SELECT usuarios.usuId, detalleplanmejoramiento.detPlanId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido FROM usuarios "
                        . "INNER JOIN detalleplanmejoramiento ON usuarios.usuId=detalleplanmejoramiento.detIdAprendiz "
                        . "INNER JOIN planmejoramiento ON detalleplanmejoramiento.detIdPlan=planmejoramiento.planId "
                        . "WHERE planmejoramiento.planId='" . $res[$i]['planId'] . "'");
                $resaprendices = $aprendices->fetchall();
                $array2 = array();
                for ($j = 0; $j < count($resaprendices); $j++) {
                    $e2 = array();
                    $e2['usuId'] = $resaprendices[$j]['usuId'];
                    $e2['detPlanId'] = $resaprendices[$j]['detPlanId'];
                    $e2['usuTipoDocu'] = $resaprendices[$j]['usuTipoDocu'];
                    $e2['usuDocumento'] = $resaprendices[$j]['usuDocumento'];
                    $e2['usuNombre'] = $resaprendices[$j]['usuNombre'];
                    $e2['usuApellido'] = $resaprendices[$j]['usuApellido'];
                    array_push($array2, $e2);
                }
                $e['aprendices'] = $array2;
                array_push($array, $e);
            }
            return $array;
        }
    }

    function bajaplanesmejoramiento($arg = false) {
        if ($arg) {
            $sql = $this->_db->exec("UPDATE planmejoramiento SET planmejoramiento.planEstado='Cancelado' WHERE planmejoramiento.planId='" . $arg . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function setplanmejoramiento() {
        if ($_POST) {
            date_default_timezone_set('America/Bogota');
            $ano = date('Y');
            $mes = date('m');
            $dia = date('d');
            $fecha = "$ano/$mes/$dia";
            $usuario = Session::get('codigo');
            $sql = $this->_db->exec("INSERT INTO planmejoramiento(planId, planFecha, planPlazoEntrega, planDescripcionActividad, planSolicita, planIdFicha, planEstado) "
                    . "VALUES ('" . $_POST['txtCodigo'] . "','" . $fecha . "','" . $_POST['txtFecha'] . "','" . $_POST['txtDescripcionActividad'] . "','" . $usuario . "','" . $_POST['txtFichasGeneral'] . "','Pendiente') "
                    . " ON DUPLICATE KEY UPDATE planPlazoEntrega='" . $_POST['txtFecha'] . "', planDescripcionActividad='" . $_POST['txtDescripcionActividad'] . "'");
            $id = $this->_db->lastInsertId();
            if (empty($id)) {
                $id = $_POST['txtCodigo'];
            }
            for ($i = 0; $i < count($_POST['txtAprendiz']); $i++) {
                $detalle = $this->_db->exec("INSERT INTO detalleplanmejoramiento(detPlanId, detIdPlan, detIdAprendiz) "
                        . "VALUES ('" . $_POST['txtCodigoAprendiz'][$i] . "','" . $id . "','" . $_POST['txtAprendiz'][$i] . "')");
            }
            return true;
        } else {
            return 0;
        }
    }

    function oneusuariosplanmejoramiento() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT planmejoramiento.planId, planmejoramiento.planPlazoEntrega, planmejoramiento.planDescripcionActividad, instituciones.instId, programas.proId, fichas.fchaId FROM planmejoramiento "
                    . "INNER JOIN fichas ON planmejoramiento.planIdFicha=fichas.fchaId "
                    . "INNER JOIN instituciones ON fichas.fchaIdInstitucion=instituciones.instId "
                    . "INNER JOIN programas ON fichas.fchaIdPrograma=programas.proId "
                    . "WHERE planmejoramiento.planId='" . $_POST['id'] . "'");
            $res = $sql->fetchall();
            for ($i = 0; $i < count($res); $i++) {
                $usuarios = $this->_db->query("SELECT usuarios.usuId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido FROM usuarios "
                        . "INNER JOIN detalleaprendiz ON usuarios.usuId=detalleaprendiz.detIdAprendiz "
                        . "INNER JOIN fichas ON detalleaprendiz.detIdFicha=fichas.fchaId "
                        . "INNER JOIN roles ON usuarios.usuRol=roles.rolId "
                        . "WHERE fichas.fchaId='" . $res[$i]['fchaId'] . "' AND roles.rolNombre='Aprendiz' GROUP BY usuarios.usuId ORDER BY usuarios.usuNombre");
                $resusuarios = $usuarios->fetchall();
                $array = array();
                for ($k = 0; $k < count($resusuarios); $k++) {
                    $aprendices = $this->_db->query("SELECT detalleplanmejoramiento.detPlanId FROM detalleplanmejoramiento "
                            . "WHERE detalleplanmejoramiento.detIdAprendiz='" . $resusuarios[$k]['usuId'] . "' AND detalleplanmejoramiento.detIdPlan='" . $res[$i]['planId'] . "'");
                    $resaprendices = $aprendices->fetchall();
                    $e2 = array();
                    $e2['usuId'] = $resusuarios[$k]['usuId'];
                    $e2['usuNombre'] = $resusuarios[$k]['usuNombre'];
                    $e2['usuApellido'] = $resusuarios[$k]['usuApellido'];
                    $e2['usuTipoDocu'] = $resusuarios[$k]['usuTipoDocu'];
                    $e2['usuDocumento'] = $resusuarios[$k]['usuDocumento'];
                    if (count($resaprendices) > 0) {
                        $e2['detPlanId'] = $resaprendices[0]['detPlanId'];
                    } else {
                        $e2['detPlanId'] = '';
                    }
                    array_push($array, $e2);
                }
            }
            return $array;
        } else {
            return 0;
        }
    }

    function bajadetalleplan() {
        if ($_POST) {
            $sql = $this->_db->exec("DELETE FROM detalleplanmejoramiento WHERE detalleplanmejoramiento.detPlanId='" . $_POST['planid'] . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function seleccionaprendices() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT usuarios.usuId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido FROM usuarios "
                    . "INNER JOIN detalleaprendiz ON usuarios.usuId=detalleaprendiz.detIdAprendiz "
                    . "INNER JOIN fichas ON detalleaprendiz.detIdFicha=fichas.fchaId "
                    . "INNER JOIN roles ON usuarios.usuRol=roles.rolId "
                    . "WHERE roles.rolNombre='Aprendiz' AND fichas.fchaId='" . $_POST['id'] . "' "
                    . "GROUP BY usuarios.usuId ORDER BY usuarios.usuNombre");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function oneficha($arg = false, $arg2 = false) {
        if ($arg && $arg2) {
            $sql = $this->_db->query("SELECT fichas.fchaId, fichas.fchaNumero FROM fichas "
                    . "WHERE fichas.fchaIdPrograma='" . $arg . "' AND fichas.fchaIdInstitucion='" . $arg2 . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function oneplanmejoramiento() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT planmejoramiento.planId, planmejoramiento.planPlazoEntrega, planmejoramiento.planDescripcionActividad, instituciones.instId, programas.proId, fichas.fchaId FROM planmejoramiento "
                    . "INNER JOIN fichas ON planmejoramiento.planIdFicha=fichas.fchaId "
                    . "INNER JOIN instituciones ON fichas.fchaIdInstitucion=instituciones.instId "
                    . "INNER JOIN programas ON fichas.fchaIdPrograma=programas.proId "
                    . "WHERE planmejoramiento.planId='" . $_POST['id'] . "'");
            $res = $sql->fetchall();
            $array = array();
            for ($i = 0; $i < count($res); $i++) {
                $e = array();
                $e['planId'] = $res[$i]['planId'];
                $e['planPlazoEntrega'] = $res[$i]['planPlazoEntrega'];
                $e['planDescripcionActividad'] = $res[$i]['planDescripcionActividad'];
                $e['instId'] = $res[$i]['instId'];
                $e['proId'] = $res[$i]['proId'];
                $e['fchaId'] = $res[$i]['fchaId'];
                $usuarios = $this->_db->query("SELECT usuarios.usuId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido FROM usuarios "
                        . "INNER JOIN detalleaprendiz ON usuarios.usuId=detalleaprendiz.detIdAprendiz "
                        . "INNER JOIN fichas ON detalleaprendiz.detIdFicha=fichas.fchaId "
                        . "INNER JOIN roles ON usuarios.usuRol=roles.rolId "
                        . "WHERE fichas.fchaId='" . $res[$i]['fchaId'] . "' AND roles.rolNombre='Aprendiz' GROUP BY usuarios.usuId ORDER BY usuarios.usuNombre");
                $resusuarios = $usuarios->fetchall();
                $array2 = array();
                for ($k = 0; $k < count($resusuarios); $k++) {
                    $aprendices = $this->_db->query("SELECT detalleplanmejoramiento.detPlanId FROM detalleplanmejoramiento "
                            . "WHERE detalleplanmejoramiento.detIdAprendiz='" . $resusuarios[$k]['usuId'] . "' AND detalleplanmejoramiento.detIdPlan='" . $res[$i]['planId'] . "'");
                    $resaprendices = $aprendices->fetchall();
                    $e2 = array();
                    $e2['usuId'] = $resusuarios[$k]['usuId'];
                    $e2['usuNombre'] = $resusuarios[$k]['usuNombre'];
                    $e2['usuApellido'] = $resusuarios[$k]['usuApellido'];
                    $e2['usuTipoDocu'] = $resusuarios[$k]['usuTipoDocu'];
                    $e2['usuDocumento'] = $resusuarios[$k]['usuDocumento'];
                    if (count($resaprendices) > 0) {
                        $e2['detPlanId'] = $resaprendices[0]['detPlanId'];
                    } else {
                        $e2['detPlanId'] = '';
                    }
                    array_push($array2, $e2);
                }
                $e['aprendices'] = $array2;
                array_push($array, $e);
            }
            return $array;
        } else {
            return 0;
        }
    }

    function listarplanesdemejoramiento() {
        date_default_timezone_set('America/Bogota');
        $ano = date('Y');
        $mes = date('m');
        $dia = date('d');
        $fecha = "$ano/$mes/$dia";
        $usuario = Session::get('codigo');
        if (Session::get('perfil') == 'Instructor') {
            $ficha = $this->_db->query("SELECT fichas.fchaId FROM fichas "
                    . "INNER JOIN detalleaprendiz ON fichas.fchaId=detalleaprendiz.detIdFicha "
                    . "WHERE detalleaprendiz.detIdAprendiz='" . $usuario . "'");
            $resfichas = $ficha->fetchall();
            $array = array();
            for ($i = 0; $i < count($resfichas); $i++) {
                $sql = $this->_db->query("SELECT planmejoramiento.planId, planmejoramiento.planFecha, planmejoramiento.planPlazoEntrega, planmejoramiento.planDescripcionActividad, usuarios.usuNombre, usuarios.usuApellido, planmejoramiento.planEstado FROM planmejoramiento "
                        . "INNER JOIN usuarios ON planmejoramiento.planSolicita=usuarios.usuId "
                        . "WHERE planmejoramiento.planPlazoEntrega>='" . $fecha . "' AND planmejoramiento.planIdFicha='" . $resfichas[$i]['fchaId'] . "'");
                $res = $sql->fetchall();
                for ($j = 0; $j < count($res); $j++) {
                    $array2 = array();
                    $datos = $this->_db->query("SELECT usuarios.usuNombre, usuarios.usuApellido FROM usuarios "
                            . "INNER JOIN detalleplanmejoramiento ON usuarios.usuId=detalleplanmejoramiento.detIdAprendiz "
                            . "INNER JOIN planmejoramiento ON detalleplanmejoramiento.detIdPlan=planmejoramiento.planId "
                            . "WHERE planmejoramiento.planId='" . $res[$j]['planId'] . "'");
                    $resdatos = $datos->fetchall();
                    $e['planId'] = $res[$j]['planId'];
                    $e['planFecha'] = $res[$j]['planFecha'];
                    $e['planPlazoEntrega'] = $res[$j]['planPlazoEntrega'];
                    $e['planDescripcionActividad'] = $res[$j]['planDescripcionActividad'];
                    $e['usuNombre'] = $res[$j]['usuNombre'];
                    $e['usuApellido'] = $res[$j]['usuApellido'];
                    $e['planEstado'] = $res[$j]['planEstado'];
                    for ($k = 0; $k < count($resdatos); $k++) {
                        $e2 = array();
                        $e2['usuNombre'] = $resdatos[$k]['usuNombre'];
                        $e2['usuApellido'] = $resdatos[$k]['usuApellido'];
                        array_push($array2, $e2);
                    }
                    $e['aprendices'] = $array2;
                    array_push($array, $e);
                }
            }
        } else {
            $array = array();
            $sql = $this->_db->query("SELECT planmejoramiento.planId, planmejoramiento.planFecha, planmejoramiento.planPlazoEntrega, planmejoramiento.planDescripcionActividad, usuarios.usuNombre, usuarios.usuApellido, planmejoramiento.planEstado FROM planmejoramiento "
                    . "INNER JOIN usuarios ON planmejoramiento.planSolicita=usuarios.usuId "
                    . "WHERE planmejoramiento.planPlazoEntrega>='" . $fecha . "'");
            $res = $sql->fetchall();
            for ($j = 0; $j < count($res); $j++) {
                $array2 = array();
                $datos = $this->_db->query("SELECT usuarios.usuNombre, usuarios.usuApellido FROM usuarios "
                        . "INNER JOIN detalleplanmejoramiento ON usuarios.usuId=detalleplanmejoramiento.detIdAprendiz "
                        . "INNER JOIN planmejoramiento ON detalleplanmejoramiento.detIdPlan=planmejoramiento.planId "
                        . "WHERE planmejoramiento.planId='" . $res[$j]['planId'] . "'");
                $resdatos = $datos->fetchall();
                $e['planId'] = $res[$j]['planId'];
                $e['planFecha'] = $res[$j]['planFecha'];
                $e['planPlazoEntrega'] = $res[$j]['planPlazoEntrega'];
                $e['planDescripcionActividad'] = $res[$j]['planDescripcionActividad'];
                $e['usuNombre'] = $res[$j]['usuNombre'];
                $e['usuApellido'] = $res[$j]['usuApellido'];
                $e['planEstado'] = $res[$j]['planEstado'];
                for ($k = 0; $k < count($resdatos); $k++) {
                    $e2 = array();
                    $e2['usuNombre'] = $resdatos[$k]['usuNombre'];
                    $e2['usuApellido'] = $resdatos[$k]['usuApellido'];
                    array_push($array2, $e2);
                }
                $e['aprendices'] = $array2;
                array_push($array, $e);
            }
        }
        return $array;
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
            $sql = $this->_db->query("SELECT comites.comId, comites.comFechaComite, comites.comHoraComite, comites.comLugar FROM comites WHERE comites.comId='" . $_POST['id'] . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function usuarioscorreo() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT usuarios.usuNombre, usuarios.usuApellido, usuarios.usuCorreo, comites.comFechaComite, comites.comHoraComite, roles.rolNombre, comites.comLugar FROM usuarios "
                    . "INNER JOIN detallecomite ON usuarios.usuId=detallecomite.detComUsuario "
                    . "INNER JOIN comites ON detallecomite.detComComite=comites.comId "
                    . "INNER JOIN roles ON usuarios.usuRol=roles.rolId "
                    . "WHERE comites.comId='" . $_POST['txtCodigo'] . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function setagendacomite() {
        if ($_POST) {
            $sql = $this->_db->exec("UPDATE comites SET comites.comFechaComite='" . $_POST['txtFecha'] . "', comites.comHoraComite='" . $_POST['txtHora'] . "', comites.comEstado='Programado', comites.comLugar='" . $_POST['txtLugar'] . "' WHERE comites.comId='" . $_POST['txtCodigo'] . "'");
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
                    . "WHERE fichas.fchaId='" . $resficha[0]['actIdFicha'] . "' AND roles.rolId='3' GROUP BY usuarios.usuId ORDER BY usuarios.usuNombre");
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
                    . "WHERE detallecomite.detComComite='" . $res[$i]['comId'] . "' AND fichas.fchaId='" . $resficha[0]['actIdFicha'] . "' AND usuarios.usuRol='4' GROUP BY usuarios.usuId");
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
            $sql = $this->_db->exec("INSERT INTO comites(comFechaSolicitud, comIdActa, comIdSolicitante, comEstado, comIdFicha) "
                    . "VALUES ('" . $fecha . "','" . $_POST['txtActa'] . "','" . $usuario . "','Pendiente','" . $_POST['txtFichaCodigo'] . "')");
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
                    . "WHERE roles.rolNombre='Aprendiz' AND fichas.fchaId='" . $_POST['ficha'] . "' GROUP BY usuarios.usuId ORDER BY usuarios.usuNombre");
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
                $actualizarhoras = $this->_db->exec("UPDATE asistencia SET asistencia.asisRegHoras='" . $_POST['txtHoras'] . "' WHERE asistencia.asisId='" . $resvalida[0]['asisId'] . "'");
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
                $sql = $this->_db->exec("INSERT INTO asistencia(asisFecha, asisHora, asisEncargado, asisFicha, asisRegHoras) "
                        . "VALUES ('" . $fecha . "','" . $hora . "','" . $usuario . "','" . $_POST['txtFichaCodigo'] . "','" . $_POST['txtHoras'] . "')");
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

    function listahoras() {
        if ($_POST) {
            date_default_timezone_set('America/Bogota');
            $ano = date('Y');
            $mes = date('m');
            $dia = date('d');
            $fecha = "$ano/$mes/$dia";
            $sql = $this->_db->query("SELECT asistencia.asisRegHoras FROM asistencia "
                    . "WHERE asistencia.asisFecha='" . $fecha . "' AND asistencia.asisFicha='" . $_POST['ficha'] . "'");
            return $sql->fetchall();
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
                    . "WHERE roles.rolNombre='Aprendiz' AND fichas.fchaId='" . $_POST['ficha'] . "' GROUP BY usuarios.usuId ORDER BY usuarios.usuNombre");
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
                . "WHERE roles.rolNombre='Aprendiz' AND fichas.fchaNumero IS NULL GROUP BY usuarios.usuId ORDER BY usuarios.usuNombre");
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
