<?php
require_once __DIR__ . '/../vendor/autoload.php';

use BieProject\Belajar\PHP\LoginManage\APP\Router;
use BieProject\Belajar\PHP\LoginManage\Config\Database;
use BieProject\Belajar\PHP\LoginManage\Controller\HomeController;
use BieProject\Belajar\PHP\LoginManage\Controller\UserController;
use BieProject\Belajar\PHP\LoginManage\Middleware\MustLoginMiddleware;
use BieProject\Belajar\PHP\LoginManage\Middleware\MustNotLoginMiddleware;

Database::getConnection('prod');

//Home Controller
Router::add('GET', '/', HomeController::class, 'index', []);

//User Controller
Router::add('GET', '/users/register', UserController::class, 'register', [MustNotLoginMiddleware:: class]);
Router::add('POST', '/users/register', UserController:: class, 'postRegister', [MustNotLoginMiddleware::class]);
Router::add('GET', '/users/login', UserController::class, 'login', [MustNotLoginMiddleware::class]);
Router::add('POST', '/users/login', UserController::class, 'postLogin', [MustNotLoginMiddleware::class]);
Router::add('GET', '/users/logout', UserController::class, 'logout', [MustLoginMiddleware::class]);

Router::run();
?>