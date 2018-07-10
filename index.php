<?php

if (isset($_COOKIE['user']) && $_COOKIE['pass']) {
    
} else {
    $dominio = $_SERVER["HTTP_HOST"];
    setcookie("user", null, time() + 3600, "/", $dominio);
    setcookie("pass", null, time() + 3600, "/", $dominio);
}
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
try {
    require_once ROOT . 'core/Config.php';
    require_once ROOT . 'core/Request.php';
    require_once ROOT . 'core/Bootstrap.php';
    require_once ROOT . 'core/Controller.php';
    require_once ROOT . 'core/Model.php';
    require_once ROOT . 'core/View.php';
    require_once ROOT . 'core/Database.php';
    require_once ROOT . 'core/Session.php';
    require_once ROOT . 'core/Hash.php';
    require_once ROOT . 'core/Registry.php';
    $registry = Registry::getInstancia();
    Session::init();
    Bootstrap::run($registry->_request);
} catch (Exception $e) {
    echo $e->getMessage();
}