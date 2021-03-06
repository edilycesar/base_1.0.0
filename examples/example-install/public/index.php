<?php
session_start();
require_once '../vendor/autoload.php';
require_once '../config/app-config.php';

define('GL_ROOT', getcwd() . '/..');
$con = new Edily\Base\Config();
$con->setGlobalRoot(GL_ROOT);
$con->write();

require_once '../vendor/edily/base/config.php';
require_once FW_ROOT . '/boot.php';

/*
*Edily Base
*/
$router = new Edily\Base\Router();
$loader = new Edily\Base\Loader();
$ret = $loader->run();
$view = new Edily\Base\View();
$view->obj = $loader->obj;//Passa objeto controller instanciado;

$view->render($ret);