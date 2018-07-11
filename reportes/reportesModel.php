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

    function reporteasistencia() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT usuarios.usuId, usuarios.usuTipoDocu, usuarios.usuDocumento, usuarios.usuNombre, usuarios.usuApellido, usuarios.usuCorreo, usuarios.usuTelefono FROM detalleaprendiz "
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
                $dias = $this->_db->query("SELECT DATE_FORMAT(asistencia.asisFecha,'%b') as mes, DAY(asistencia.asisFecha) as dia, detalleasistencia.detEstado FROM detalleasistencia "
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
                    array_push($arraydias, $e3);
                }
                $e['dias'] = $arraydias;
                array_push($array, $e);
            }
            return $array;
        } else {
            return 0;
        }
    }

}
