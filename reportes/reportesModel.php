<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of reportesModel
 *
 * @author Ruben1997
 */
class reportesModel extends Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function novedadesaprendiz() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT registranovedades.rnovId, registranovedades.rnovDescripcion, registranovedades.rnovFecha, registranovedades.rnovHora, novedadespredefinidas.novpNovedad, deberesreglamento.debDescripcion, registranovedades.rnovTipo FROM registranovedades "
                    . "INNER JOIN novedadespredefinidas ON registranovedades.rnovIdNovedad=novedadespredefinidas.novpId "
                    . "INNER JOIN deberesreglamento ON novedadespredefinidas.novpIdDeber=deberesreglamento.debId "
                    . "INNER JOIN detallenovedad ON registranovedades.rnovId=detallenovedad.dnovIdNovedad "
                    . "WHERE detallenovedad.dnovAprendiz='" . $_POST['id'] . "' ORDER BY registranovedades.rnovFecha DESC");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function usuariosreportenovedades() {
        if ($_POST) {
            if (!empty($_POST['aprendiz'])) {
                $sql = $this->_db->query("SELECT usuarios.usuId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido, usuarios.usuCorreo, usuarios.usuTelefono FROM usuarios "
                        . "INNER JOIN detalleaprendiz ON usuarios.usuId=detalleaprendiz.detIdAprendiz "
                        . "INNER JOIN fichas ON detalleaprendiz.detIdFicha=fichas.fchaId "
                        . "INNER JOIN roles ON usuarios.usuRol=roles.rolId "
                        . "WHERE roles.rolNombre='Aprendiz' AND fichas.fchaId='" . $_POST['ficha'] . "' AND usuarios.usuId='" . $_POST['aprendiz'] . "' "
                        . "GROUP BY usuarios.usuId ORDER BY usuarios.usuNombre");
            } else {
                $sql = $this->_db->query("SELECT usuarios.usuId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido, usuarios.usuCorreo, usuarios.usuTelefono FROM usuarios "
                        . "INNER JOIN detalleaprendiz ON usuarios.usuId=detalleaprendiz.detIdAprendiz "
                        . "INNER JOIN fichas ON detalleaprendiz.detIdFicha=fichas.fchaId "
                        . "INNER JOIN roles ON usuarios.usuRol=roles.rolId "
                        . "WHERE roles.rolNombre='Aprendiz' AND fichas.fchaId='" . $_POST['ficha'] . "' "
                        . "GROUP BY usuarios.usuId ORDER BY usuarios.usuNombre");
            }
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
                $novedades = $this->_db->query("SELECT COUNT(detallenovedad.dnovId) as cant FROM detallenovedad "
                        . "WHERE detallenovedad.dnovAprendiz='" . $res[$i]['usuId'] . "'");
                $resnovedades = $novedades->fetchall();
                if (count($resnovedades) > 0) {
                    $e['novedades'] = $resnovedades[0]['cant'];
                } else {
                    $e['novedades'] = 0;
                }
                array_push($array, $e);
            }
            return $array;
        } else {
            return 0;
        }
    }

    function usuariosasistencia() {
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

    function filtracomites() {
        if ($_POST) {
            date_default_timezone_set('America/Bogota');
            $ano = date('Y');
            $mes = date('m');
            $dia = date('d');
            $fecha = "$ano/$mes/$dia";
            $sql = $this->_db->query("SELECT comites.comId, comites.comFechaSolicitud, actas.actRuta, actas.actNumero, usuarios.usuNombre, usuarios.usuApellido, comites.comEstado, comites.comFechaComite, comites.comHoraComite, comites.comIdFicha FROM comites "
                    . "INNER JOIN actas ON comites.comIdActa=actas.actId "
                    . "INNER JOIN usuarios ON comites.comIdSolicitante=usuarios.usuId "
                    . "WHERE comites.comIdFicha='" . $_POST['id'] . "' "
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
                $usuarios = $this->_db->query("SELECT usuarios.usuNombre, usuarios.usuApellido, fichas.fchaNumero FROM detallecomite "
                        . "INNER JOIN usuarios ON detallecomite.detComUsuario=usuarios.usuId "
                        . "INNER JOIN detalleaprendiz ON usuarios.usuId=detalleaprendiz.detIdAprendiz "
                        . "INNER JOIN fichas ON detalleaprendiz.detIdFicha=fichas.fchaId "
                        . "WHERE detallecomite.detComComite='" . $res[$i]['comId'] . "' AND fichas.fchaId='" . $res[$i]['comIdFicha'] . "' AND usuarios.usuRol='4' GROUP BY usuarios.usuId");
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
                if (Session::get('perfil') == 'Instructor') {
                    $instructores = $this->_db->query("SELECT * FROM detallecomite "
                            . "WHERE detallecomite.detComUsuario='" . Session::get('codigo') . "' AND detallecomite.detComComite='" . $res[$i]['comId'] . "'");
                    $resinstructor = $instructores->fetchall();
                    if (count($resinstructor) > 0) {
                        $e['boton'] = 'A';
                    } else {
                        $e['boton'] = 'I';
                    }
                } else {
                    $e['boton'] = 'A';
                }
                array_push($array, $e);
            }
            return $array;
        } else {
            return 0;
        }
    }

    function fichacomite() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT fichas.fchaId FROM fichas "
                    . "INNER JOIN actas ON fichas.fchaId=actas.actIdFicha "
                    . "INNER JOIN comites ON actas.actId=comites.comIdActa "
                    . "WHERE comites.comId='" . $_POST['id'] . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function listaaprendices() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT usuarios.usuId, usuarios.usuNombre, usuarios.usuApellido, usuarios.usuTipoDocu, usuarios.usuDocumento, roles.rolNombre FROM usuarios "
                    . "INNER JOIN detallecomite ON usuarios.usuId=detallecomite.detComUsuario "
                    . "INNER JOIN comites ON detallecomite.detComComite=comites.comId "
                    . "INNER JOIN roles ON usuarios.usuRol=roles.rolId "
                    . "WHERE comites.comId='" . $_POST['id'] . "' ORDER BY usuarios.usuNombre");
            $res = $sql->fetchall();
            return $res;
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

    function setplanmejoramiento() {
        if ($_POST) {
            date_default_timezone_set('America/Bogota');
            $ano = date('Y');
            $mes = date('m');
            $dia = date('d');
            $fecha = "$ano/$mes/$dia";
            $usuario = Session::get('codigo');
            $sql = $this->_db->exec("INSERT INTO planmejoramiento(planFecha, planPlazoEntrega, planDescripcionActividad, planSolicita, planEstado, planIdFicha) "
                    . "VALUES ('" . $fecha . "','" . $_POST['txtFecha'] . "','" . $_POST['txtDescripcionActividad'] . "','" . $usuario . "','Pendiente','" . $_POST['txtCodigoFicha'] . "')");
            $id = $this->_db->lastInsertId();
            for ($i = 0; $i < count($_POST['txtAprendiz']); $i++) {
                $plan = $this->_db->exec("INSERT INTO detalleplanmejoramiento(detIdPlan, detIdAprendiz) "
                        . "VALUES ('" . $id . "','" . $_POST['txtAprendiz'][$i] . "')");
            }
            return $sql;
        } else {
            return 0;
        }
    }

    function usuarioscomite() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT usuarios.usuId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido FROM usuarios "
                    . "INNER JOIN detallecomite ON usuarios.usuId=detallecomite.detComUsuario "
                    . "INNER JOIN roles ON usuarios.usuRol=roles.rolId "
                    . "WHERE detallecomite.detComComite='" . $_POST['id'] . "' AND roles.rolNombre='Aprendiz'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function reporteasistencia() {
        if ($_POST) {
            if (!empty($_POST['aprendiz'])) {
                $sql = $this->_db->query("SELECT usuarios.usuId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido, usuarios.usuCorreo, usuarios.usuTelefono FROM detalleaprendiz "
                        . "INNER JOIN usuarios ON detalleaprendiz.detIdAprendiz=usuarios.usuId "
                        . "INNER JOIN fichas ON detalleaprendiz.detIdFicha=fichas.fchaId "
                        . "INNER JOIN roles ON usuarios.usuRol=roles.rolId "
                        . "WHERE roles.rolNombre='Aprendiz' AND fichas.fchaId='" . $_POST['ficha'] . "' AND usuarios.usuId='" . $_POST['aprendiz'] . "' GROUP BY usuarios.usuId ORDER BY usuarios.usuNombre");
            } else {
                $sql = $this->_db->query("SELECT usuarios.usuId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido, usuarios.usuCorreo, usuarios.usuTelefono FROM detalleaprendiz "
                        . "INNER JOIN usuarios ON detalleaprendiz.detIdAprendiz=usuarios.usuId "
                        . "INNER JOIN fichas ON detalleaprendiz.detIdFicha=fichas.fchaId "
                        . "INNER JOIN roles ON usuarios.usuRol=roles.rolId "
                        . "WHERE roles.rolNombre='Aprendiz' AND fichas.fchaId='" . $_POST['ficha'] . "' GROUP BY usuarios.usuId ORDER BY usuarios.usuNombre");
            }
            $res = $sql->fetchall();
            $array = array();
            for ($i = 0; $i < count($res); $i++) {
                $e = array();
                $contador = 0;
                $e['usuId'] = $res[$i]['usuId'];
                $e['usuTipoDocu'] = $res[$i]['usuTipoDocu'];
                $e['usuDocumento'] = $res[$i]['usuDocumento'];
                $e['usuNombre'] = $res[$i]['usuNombre'];
                $e['usuApellido'] = $res[$i]['usuApellido'];
                $e['usuCorreo'] = $res[$i]['usuCorreo'];
                $e['usuTelefono'] = $res[$i]['usuCorreo'];
                $meses = $this->_db->query("SELECT DATE_FORMAT(asistencia.asisFecha,'%b') as mes FROM detalleasistencia "
                        . "INNER JOIN asistencia ON detalleasistencia.detIdAsistencia=asistencia.asisId "
                        . "WHERE asistencia.asisFecha BETWEEN '" . $_POST['fi'] . "' AND '" . $_POST['ff'] . "' "
                        . "AND asistencia.asisFicha='" . $_POST['ficha'] . "' "
                        . "GROUP BY mes ORDER BY asistencia.asisFecha");
                $resmes = $meses->fetchall();
                $arraymeses = array();
                for ($j = 0; $j < count($resmes); $j++) {
                    $e2 = array();
                    $e2['mes'] = $resmes[$j]['mes'];
                    array_push($arraymeses, $e2);
                }
                $e['meses'] = $arraymeses;
                $dias = $this->_db->query("SELECT DATE_FORMAT(asistencia.asisFecha,'%b') as mes, DAY(asistencia.asisFecha) as dia, detalleasistencia.detEstado, asistencia.asisRegHoras FROM detalleasistencia "
                        . "INNER JOIN asistencia ON detalleasistencia.detIdAsistencia=asistencia.asisId "
                        . "WHERE detalleasistencia.detIdAprendiz='" . $res[$i]['usuId'] . "' "
                        . "AND asistencia.asisFecha BETWEEN '" . $_POST['fi'] . "' AND '" . $_POST['ff'] . "' "
                        . "GROUP BY mes, dia");
                $resdias = $dias->fetchall();
                $arraydias = array();
                for ($k = 0; $k < count($resdias); $k++) {
                    $e3 = array();
                    $e3['mesdia'] = $resdias[$k]['mes'];
                    $e3['dia'] = $resdias[$k]['dia'];
                    $e3['estado'] = $resdias[$k]['detEstado'];
                    if ($resdias[$k]['detEstado'] == 'I') {
                        $contador = $contador + $resdias[$k]['asisRegHoras'];
                    }
                    array_push($arraydias, $e3);
                }
                $e['dias'] = $arraydias;
                $e['cantidadhoras'] = $contador;
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
        $sql = $this->_db->query("SELECT comites.comId, comites.comFechaSolicitud, actas.actRuta, actas.actNumero, usuarios.usuNombre, usuarios.usuApellido, comites.comEstado, comites.comFechaComite, comites.comHoraComite, comites.comIdFicha FROM comites "
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
            $usuarios = $this->_db->query("SELECT usuarios.usuNombre, usuarios.usuApellido, fichas.fchaNumero FROM detallecomite "
                    . "INNER JOIN usuarios ON detallecomite.detComUsuario=usuarios.usuId "
                    . "INNER JOIN detalleaprendiz ON usuarios.usuId=detalleaprendiz.detIdAprendiz "
                    . "INNER JOIN fichas ON detalleaprendiz.detIdFicha=fichas.fchaId "
                    . "WHERE detallecomite.detComComite='" . $res[$i]['comId'] . "' AND fichas.fchaId='" . $res[$i]['comIdFicha'] . "' AND usuarios.usuRol='4' GROUP BY usuarios.usuId");
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
            if (Session::get('perfil') == 'Instructor') {
                $instructores = $this->_db->query("SELECT * FROM detallecomite "
                        . "WHERE detallecomite.detComUsuario='" . Session::get('codigo') . "' AND detallecomite.detComComite='" . $res[$i]['comId'] . "'");
                $resinstructor = $instructores->fetchall();
                if (count($resinstructor) > 0) {
                    $e['boton'] = 'A';
                } else {
                    $e['boton'] = 'I';
                }
            } else {
                $e['boton'] = 'A';
            }
            array_push($array, $e);
        }
        return $array;
    }

}
