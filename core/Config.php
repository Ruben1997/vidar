<?php

define('RUTA_URL', 'http://localhost/vidar/');
define('COMMON', RUTA_URL . 'public/common/');
define('BASE_URL_LIB', ROOT . 'core/library' . DS);
define('DEFAULT_CONTROLLER', 'inicio');
define('DEFAULT_METHOD', 'index');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'vidar');
define('DB_CHAR', 'utf8');
define('NAME_APP', 'Vidar');
define('HASH_KEY', '53bf025929f1f');
define('SESSION_TIME', 60);

$timepicker = "<link href='" . COMMON . "timepicker/clockface.css' rel='stylesheet'>
        <link href='" . COMMON . "timepicker/calendarpicker.css' rel='stylesheet'>        
        <script src='" . COMMON . "timepicker/clockface.js'></script>
        <script src='" . COMMON . "timepicker/calendarpicker.js'></script>";
define('LIB_TIMEPICKER', $timepicker);

class Funcionesphp {

    public static function noCache() {
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    }

    public static function MesActual() {
        $meses = array(
            array(
                'val' => '01',
                'mes' => 'Enero'
            ),
            array(
                'val' => '02',
                'mes' => 'Febrero'
            ),
            array(
                'val' => '03',
                'mes' => 'Marzo'
            ),
            array(
                'val' => '04',
                'mes' => 'Abril'
            ),
            array(
                'val' => '05',
                'mes' => 'Mayo'
            ),
            array(
                'val' => '06',
                'mes' => 'Junio'
            ),
            array(
                'val' => '07',
                'mes' => 'Julio'
            ),
            array(
                'val' => '08',
                'mes' => 'Agosto'
            ),
            array(
                'val' => '09',
                'mes' => 'Septiembre'
            ),
            array(
                'val' => '10',
                'mes' => 'Octubre'
            ),
            array(
                'val' => '11',
                'mes' => 'Noviembre'
            ),
            array(
                'val' => '12',
                'mes' => 'Diciembre'
            ),
        );
        $month = date("m");
        $mes = "";
        for ($i = 0; $i < count($meses); $i++) {
            if ($meses[$i]['val'] == $month) {
                $mes = $meses[$i]['mes'];
            }
        }
        return $mes;
    }

}
