<?php

class Session {

    public static function init() {
        session_start();
    }

    public static function destroy($clave = FALSE) {
        if ($clave) {
            if (is_array($clave)) {
                for ($i = 0; $i < count($clave); $i++) {
                    if (isset($_SESSION[$clave[$i]])) {
                        unset($_SESSION[$clave[$i]]);
                    }
                }
            } else {
                if (isset($_SESSION[$clave])) {
                    unset($_SESSION[$clave]);
                }
            }
        } else {
            session_destroy();
        }
    }

    public static function set($clave, $valor) {
        if (!empty($clave)) {
            $_SESSION[$clave] = $valor;
        }
    }

    public static function get($clave) {
        if (isset($_SESSION[$clave])) {
            return $_SESSION[$clave];
        }
    }

    public static function acceso($level) {
        if (!Session::get('autenticado')) {
            header('location:' . RUTA_URL . 'error/access/5050');
            exit;
        }

        if (Session::getLevel($level) > Session::getLevel(Session::get('perfil'))) {
            header('location:' . RUTA_URL . 'error/access/5050');
            exit;
        }
    }

    public static function accesoView($level) {

        if (!Session::get('autenticado')) {
            return FALSE;
        }
        if (Session::getLevel($level) > Session::getLevel(Session::get('perfil'))) {
            return FALSE;
        }

        return true;
    }

    public static function getLevel($level) {
        $rol['Coordinador Academico'] = 3;
        $rol['Instructor'] = 2;
        $rol['Administrador'] = 1;

        if (array_key_exists($level, $rol)) {
            return $rol[$level];
        } else {
            throw new Exception('Error de acceso');
        }
    }

    public static function accesoEstricto(array $level, $noAdmin = FALSE) {
        if (!Session::get('autenticado')) {
            header('location:' . RUTA_URL . 'error/access/5050');
            exit;
        }
        if ($noAdmin == false) {
            if (Session::get('perfil') == 'Administrador') {
                return;
            }
        }

        if (count($level)) {
            if (in_array(Session::get('perfil'), $level)) {
                return;
            }
        }

        header('location:' . RUTA_URL . 'error/access/5050');
    }

    public static function accesoViewEstricto(array $level, $noAdmin = FALSE) {
        if (!Session::get('autenticado')) {
            return false;
        }
        if ($noAdmin == false) {
            if (Session::get('perfil') == 'Administrador') {
                return true;
            }
        }

        if (count($level)) {
            if (in_array(Session::get('perfil'), $level)) {
                return true;
            }
        }

        return false;
    }

}

?>
