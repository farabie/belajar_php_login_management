<?php 

namespace BieProject\Belajar\PHP\LoginManage\Controller;

use BieProject\Belajar\PHP\LoginManage\APP\View;
use BieProject\Belajar\PHP\LoginManage\Config\Database;
use BieProject\Belajar\PHP\LoginManage\Repository\UserRepository;
use BieProject\Belajar\PHP\LoginManage\Service\UserService;

class UserController {
    private UserService $userService;
    

    public function __construct() {
        $connection = Database::getConnection();
        $userRepository = new UserRepository($connection);
        $this->userService = new UserService($userRepository);
    }


    //Menampilkan halam registerasi
    public function register () {
        View::render('User/register', [
            'title' => 'Register new User'
        ]);
    }
}


?>