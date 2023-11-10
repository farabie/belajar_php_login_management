<?php
require_once __DIR__ . '/../vendor/autoload.php';

use BieProject\Belajar\PHP\LoginManage\APP\Router;
use BieProject\Belajar\PHP\LoginManage\Controller\HomeController;

Router::add('GET', '/', HomeController::class, 'index', []);
Router::run();
?>