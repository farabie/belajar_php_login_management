<?php

namespace BieProject\Belajar\PHP\LoginManage\Controller;

use BieProject\Belajar\PHP\LoginManage\APP\View;
use BieProject\Belajar\PHP\LoginManage\Config\Database;
use BieProject\Belajar\PHP\LoginManage\Repository\SessionRepository;
use BieProject\Belajar\PHP\LoginManage\Repository\UserRepository;
use BieProject\Belajar\PHP\LoginManage\Service\SessionService;

class HomeController
{
    private SessionService $sessionService;

    public function __construct() {
        $connection = Database::getConnection();
        $sessionRepository = new SessionRepository($connection);
        $userRepository = new UserRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    function index() {
        $user = $this->sessionService->current();

        if($user == null) {
            View::render('Home/index', [
                "title" => "PHP Login Management"
            ]);
        }else {
            View::render('Home/dashboard', [
                "title" => "Dashboard",
                "user" => [
                    "name" => $user->name
                ]
            ]);
        }
    }

}



?>