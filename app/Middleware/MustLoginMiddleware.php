<?php
//Fungsi Middleware ini jadi jika ada session maka tidak harus

namespace  BieProject\Belajar\PHP\LoginManage\Middleware;


use BieProject\Belajar\PHP\LoginManage\App\View;
use BieProject\Belajar\PHP\LoginManage\Config\Database;
use BieProject\Belajar\PHP\LoginManage\Repository\SessionRepository;
use BieProject\Belajar\PHP\LoginManage\Repository\UserRepository;
use BieProject\Belajar\PHP\LoginManage\Service\SessionService;

class MustLoginMiddleware implements Middleware
{
    private SessionService $sessionService;

    public function __construct()
    {
        $sessionRepository = new SessionRepository(Database::getConnection());
        $userRepository = new UserRepository(Database::getConnection());
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    function before(): void
    {
        $user = $this->sessionService->current();
        if ($user == null) {
            View::redirect('/users/login');
        }
    }
}

?>