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

    function cargaprogramas() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT programas.proId, programas.proNombre FROM programas "
                    . "WHERE programas.proInstitucion='" . $_POST['id'] . "' AND programas.proEstado='A' ORDER BY programas.proNombre");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function bajaaspectos($arg = false) {
        if ($arg) {
            $sql = $this->_db->exec("UPDATE novedadespredefinidas SET novedadespredefinidas.novpEstado='I' WHERE novedadespredefinidas.novpId='" . $arg . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function setapecto() {
        if ($_POST) {
            $sql = $this->_db->exec("INSERT INTO novedadespredefinidas(novpId, novpNovedad, novpIdDeber, novpEstado, novpTipo) VALUES "
                    . "('" . $_POST['txtCodigo'] . "','" . $_POST['txtDescripcion'] . "','" . $_POST['txtDeber'] . "','A','" . $_POST['txtTipo'] . "') "
                    . "ON DUPLICATE KEY UPDATE novpNovedad='" . $_POST['txtDescripcion'] . "', novpIdDeber='" . $_POST['txtDeber'] . "', novpTipo='" . $_POST['txtTipo'] . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function oneaspecto() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT novedadespredefinidas.novpId, novedadespredefinidas.novpNovedad, novedadespredefinidas.novpIdDeber, novedadespredefinidas.novpTipo FROM novedadespredefinidas "
                    . "WHERE novedadespredefinidas.novpId='" . $_POST['id'] . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function aspectospositivos() {
        $sql = $this->_db->query("SELECT novedadespredefinidas.novpId, novedadespredefinidas.novpNovedad, deberesreglamento.debDescripcion, novedadespredefinidas.novpTipo FROM novedadespredefinidas "
                . "INNER JOIN deberesreglamento ON novedadespredefinidas.novpIdDeber=deberesreglamento.debId "
                . "WHERE novedadespredefinidas.novpEstado='A' ORDER BY novedadespredefinidas.novpNovedad");
        return $sql->fetchall();
    }

    function bajareglamentos($arg = false) {
        if ($arg) {
            $sql = $this->_db->exec("UPDATE deberesreglamento SET deberesreglamento.debEstado='I' WHERE deberesreglamento.debId='" . $arg . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function setreglamento() {
        if ($_POST) {
            $sql = $this->_db->exec("INSERT INTO deberesreglamento(debId, debDescripcion, debCodigoReglamento, debEstado) "
                    . "VALUES ('" . $_POST['txtCodigo'] . "','" . $_POST['txtDescripcion'] . "','" . $_POST['txtCodigoReglamento'] . "','A') "
                    . "ON DUPLICATE KEY UPDATE debDescripcion='" . $_POST['txtDescripcion'] . "', debCodigoReglamento='" . $_POST['txtCodigoReglamento'] . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function onereglamento() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT deberesreglamento.debId, deberesreglamento.debDescripcion, deberesreglamento.debCodigoReglamento FROM deberesreglamento "
                    . "WHERE deberesreglamento.debId='" . $_POST['id'] . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function listareglamento() {
        $sql = $this->_db->query("SELECT deberesreglamento.debId, deberesreglamento.debDescripcion, deberesreglamento.debCodigoReglamento FROM deberesreglamento "
                . "WHERE deberesreglamento.debEstado='A' ORDER BY deberesreglamento.debDescripcion");
        return $sql->fetchall();
    }

    function setusuariosfichas() {
        if ($_POST) {
            for ($i = 0; $i < count($_POST['txtInstructor']); $i++) {
                $instructores = $this->_db->exec("INSERT INTO detalleaprendiz(detId, detIdAprendiz, detIdFicha) "
                        . "VALUES ('" . $_POST['txtCodigoInstructor'][$i] . "','" . $_POST['txtInstructor'][$i] . "','" . $_POST['txtFicha'] . "') "
                        . "ON DUPLICATE KEY UPDATE detIdAprendiz='" . $_POST['txtInstructor'][$i] . "', detIdFicha='" . $_POST['txtFicha'] . "'");
            }
            for ($i = 0; $i < count($_POST['txtAprendiz']); $i++) {
                $aprendices = $this->_db->exec("INSERT INTO detalleaprendiz(detId, detIdAprendiz, detIdFicha) "
                        . "VALUES ('" . $_POST['txtCodigoAprendiz'][$i] . "','" . $_POST['txtAprendiz'][$i] . "','" . $_POST['txtFicha'] . "') "
                        . "ON DUPLICATE KEY UPDATE detIdAprendiz='" . $_POST['txtAprendiz'][$i] . "', detIdFicha='" . $_POST['txtFicha'] . "'");
            }
            return true;
        } else {
            return 0;
        }
    }

    function bajadetalleusuario() {
        if ($_POST) {
            $sql = $this->_db->exec("DELETE FROM detalleaprendiz WHERE detalleaprendiz.detId='" . $_POST['id'] . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function instructoresfichas() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT usuarios.usuId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido, usuarios.usuCorreo, usuarios.usuTelefono FROM usuarios "
                    . "INNER JOIN roles ON usuarios.usuRol=roles.rolId "
                    . "WHERE roles.rolNombre='Instructor' GROUP BY usuarios.usuId ORDER BY usuarios.usuNombre");
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
                $ficha = $this->_db->query("SELECT detalleaprendiz.detId FROM detalleaprendiz "
                        . "WHERE detalleaprendiz.detIdAprendiz='" . $res[$i]['usuId'] . "' AND detalleaprendiz.detIdFicha='" . $_POST['ficha'] . "'");
                $resficha = $ficha->fetchall();
                if (count($resficha) > 0) {
                    $e['estado'] = 'A';
                    $e['detId'] = $resficha[0]['detId'];
                } else {
                    $e['estado'] = 'I';
                    $e['detId'] = '';
                }
                array_push($array, $e);
            }
            return $array;
        } else {
            return 0;
        }
    }

    function aprendicesfichas() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT usuarios.usuId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido, usuarios.usuCorreo, usuarios.usuTelefono FROM detalleaprendiz "
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
                $ficha = $this->_db->query("SELECT detalleaprendiz.detId FROM detalleaprendiz "
                        . "WHERE detalleaprendiz.detIdAprendiz='" . $res[$i]['usuId'] . "' AND detalleaprendiz.detIdFicha='" . $_POST['ficha'] . "'");
                $resficha = $ficha->fetchall();
                if (count($resficha) > 0) {
                    $e['estado'] = 'A';
                    $e['detId'] = $resficha[0]['detId'];
                } else {
                    $e['estado'] = 'I';
                    $e['detId'] = '';
                }
                array_push($array, $e);
            }
            return $array;
        } else {
            return 0;
        }
    }

    function bajaactas($arg = false) {
        if ($arg) {
            $sql = $this->_db->exec("UPDATE actas SET actas.actEstado='I' WHERE actas.actId='" . $arg . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function setacta() {
        if ($_POST) {
            date_default_timezone_set('America/Bogota');
            $ano = date('Y');
            $mes = date('m');
            $dia = date('d');
            $fecha = "$ano/$mes/$dia";
            if ($_FILES['txtArchivoActa']['error'] != 4) {
                $nombrearchivo = htmlentities($_FILES['txtArchivoActa']['name']);
                $archivo = RUTA_URL . 'public/vidarLayout/files/' . $nombrearchivo;
                $sql = $this->_db->exec("INSERT INTO actas(actId, actIdFicha, actNumero, actFecha, actRuta, actEstado) "
                        . "VALUES ('" . $_POST['txtCodigo'] . "','" . $_POST['txtFichasGeneral'] . "','" . $_POST['txtNumero'] . "','" . $fecha . "','" . $archivo . "','A') "
                        . "ON DUPLICATE KEY UPDATE actIdFicha='" . $_POST['txtFichasGeneral'] . "', actNumero='" . $_POST['txtNumero'] . "', actRuta='" . $archivo . "'");
            } else {
                $sql = $this->_db->exec("INSERT INTO actas(actId, actIdFicha, actNumero, actFecha, actEstado) "
                        . "VALUES ('" . $_POST['txtCodigo'] . "','" . $_POST['txtFichasGeneral'] . "','" . $_POST['txtNumero'] . "','" . $fecha . "','A') "
                        . "ON DUPLICATE KEY UPDATE actIdFicha='" . $_POST['txtFichasGeneral'] . "', actNumero='" . $_POST['txtNumero'] . "'");
            }
            return $sql;
        } else {
            return 0;
        }
    }

    function fichasactas($arg = false, $arg2 = false) {
        if ($arg && $arg2) {
            $sql = $this->_db->query("SELECT fichas.fchaId, fichas.fchaNumero FROM fichas "
                    . "WHERE fichas.fchaIdPrograma='" . $arg . "' AND fichas.fchaIdInstitucion='" . $arg2 . "' AND fichas.fchaEstado='A'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function oneacta() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT actas.actId, actas.actIdFicha, actas.actNumero, actas.actFecha, actas.actRuta, programas.proId, instituciones.instId FROM actas "
                    . "INNER JOIN fichas ON actas.actIdFicha=fichas.fchaId "
                    . "INNER JOIN programas ON fichas.fchaIdPrograma=programas.proId "
                    . "INNER JOIN instituciones ON fichas.fchaIdInstitucion=instituciones.instId "
                    . "WHERE actas.actId='" . $_POST['id'] . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function actas() {
        $sql = $this->_db->query("SELECT actas.actId, fichas.fchaNumero, actas.actNumero, actas.actFecha, actas.actRuta FROM actas "
                . "INNER JOIN fichas ON actas.actIdFicha=fichas.fchaId "
                . "WHERE actas.actEstado='A'");
        return $sql->fetchall();
    }

    function tablaaprendices() {
        if ($_POST) {
            $sql = "SELECT usuarios.usuId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido, usuarios.usuCorreo, usuarios.usuTelefono, fichas.fchaNumero FROM detalleaprendiz "
                    . "RIGHT JOIN usuarios ON detalleaprendiz.detIdAprendiz=usuarios.usuId "
                    . "LEFT JOIN fichas ON detalleaprendiz.detIdFicha=fichas.fchaId "
                    . "INNER JOIN roles ON usuarios.usuRol=roles.rolId "
                    . "WHERE fichas.fchaId='" . $_POST['ficha'] . "' AND roles.rolNombre='Aprendiz'";
            $datos = $this->_db->query($sql);
            return $datos->fetchall();
        } else {
            return 0;
        }
    }

    function cargaficha() {
        if ($_POST) {
            $usuario = Session::get('codigo');
            if (Session::get('perfil') == 'Instructor') {
                if (!empty($_POST['institucion']) && !empty($_POST['programa'])) {
                    $sql = $this->_db->query("SELECT fichas.fchaId, fichas.fchaNumero FROM fichas "
                            . "INNER JOIN detalleaprendiz ON fichas.fchaId=detalleaprendiz.detIdFicha "
                            . "INNER JOIN usuarios ON detalleaprendiz.detIdAprendiz=usuarios.usuId "
                            . "WHERE fichas.fchaIdPrograma='" . $_POST['programa'] . "' AND fichas.fchaIdInstitucion='" . $_POST['institucion'] . "' AND usuarios.usuId='" . $usuario . "' AND fichas.fchaEstado='A'");
                } else if (!empty($_POST['institucion']) && empty($_POST['programa'])) {
                    $sql = $this->_db->query("SELECT fichas.fchaId, fichas.fchaNumero FROM fichas "
                            . "INNER JOIN detalleaprendiz ON fichas.fchaId=detalleaprendiz.detIdFicha "
                            . "INNER JOIN usuarios ON detalleaprendiz.detIdAprendiz=usuarios.usuId "
                            . "WHERE fichas.fchaIdInstitucion='" . $_POST['institucion'] . "' AND fichas.fchaEstado='A' AND usuarios.usuId='" . $usuario . "'");
                } else if (!empty($_POST['programa']) && empty($_POST['institucion'])) {
                    $sql = $this->_db->query("SELECT fichas.fchaId, fichas.fchaNumero FROM fichas "
                            . "INNER JOIN detalleaprendiz ON fichas.fchaId=detalleaprendiz.detIdFicha "
                            . "INNER JOIN usuarios ON detalleaprendiz.detIdAprendiz=usuarios.usuId "
                            . "WHERE fichas.fchaIdPrograma='" . $_POST['programa'] . "' AND usuarios.usuId='" . $usuario . "' AND fichas.fchaEstado='A'");
                }
            } else {
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
        $sql = $this->_db->query("SELECT usuarios.usuId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido, usuarios.usuCorreo, usuarios.usuTelefono FROM usuarios "
                . "INNER JOIN roles ON usuarios.usuRol=roles.rolId "
                . "WHERE roles.rolNombre='Aprendiz' ORDER BY usuarios.usuNombre");
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
            $fichas = $this->_db->query("SELECT fichas.fchaNumero FROM detalleaprendiz "
                    . "INNER JOIN fichas ON detalleaprendiz.detIdFicha=fichas.fchaId "
                    . "INNER JOIN usuarios ON detalleaprendiz.detIdAprendiz=usuarios.usuId "
                    . "WHERE usuarios.usuId='" . $res[$i]['usuId'] . "'");
            $resfichas = $fichas->fetchall();
            $con = '';
            for ($j = 0; $j < count($resfichas); $j++) {
                if ($j == 0) {
                    $con = $con . $resfichas[$j]['fchaNumero'];
                } else {
                    $con = $con . '-' . $resfichas[$j]['fchaNumero'];
                }
            }
            $e['fichas'] = $con;
            array_push($array, $e);
        }
        return $array;
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

    function programasinstitucion($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT programas.proId, programas.proNombre FROM programas WHERE programas.proInstitucion='" . $arg . "'");
            return $sql->fetchall();
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
            $sql = $this->_db->exec("INSERT INTO programas (proId, proNombre, proEstado, proInstitucion) "
                    . "VALUES ('" . $_POST['txtCodigo'] . "','" . $_POST['txtNombre'] . "','A','" . $_POST['txtInstitucion'] . "') "
                    . "ON DUPLICATE KEY UPDATE proNombre='" . $_POST['txtNombre'] . "', proInstitucion='" . $_POST['txtInstitucion'] . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function oneprograma() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT programas.proId, programas.proNombre, programas.proInstitucion FROM programas WHERE programas.proId='" . $_POST['id'] . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function programas() {
        $sql = $this->_db->query("SELECT programas.proId, programas.proNombre, instituciones.instNombre FROM programas "
                . "INNER JOIN instituciones ON programas.proInstitucion=instituciones.instId "
                . "WHERE programas.proEstado='A'");
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
