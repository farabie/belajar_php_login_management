<?php
require_once __DIR__ . '/../vendor/autoload.php';

use BieProject\Belajar\PHP\LoginManage\APP\Router;
use BieProject\Belajar\PHP\LoginManage\Config\Database;
use BieProject\Belajar\PHP\LoginManage\Controller\HomeController;
use BieProject\Belajar\PHP\LoginManage\Controller\UserController;

Database::getConnection('prod');

//Home Controller
Router::add('GET', '/', HomeController::class, 'index', []);

//User Controller
Router::add('GET', '/users/register', UserController::class, 'register');
Router::add('POST', '/users/register', UserController:: class, 'postRegister');
Router::run();
?>