<?php 

namespace BieProject\Belajar\PHP\LoginManage\Middleware;

class AuthMiddleware implements Middleware {
    function before():void {
        session_start();
        if(!isset($_SESSION['user'])) {
            header('Location: /login');
            exit();
        }
    }
}


?>