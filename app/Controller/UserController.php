<?php 

namespace BieProject\Belajar\PHP\LoginManage\Controller;

use BieProject\Belajar\PHP\LoginManage\APP\View;
use BieProject\Belajar\PHP\LoginManage\Config\Database;
use BieProject\Belajar\PHP\LoginManage\Exception\validationException;
use BieProject\Belajar\PHP\LoginManage\Model\UserLoginRequest;
use BieProject\Belajar\PHP\LoginManage\Model\UserProfileUpdateRequest;
use BieProject\Belajar\PHP\LoginManage\Model\UserRegisterRequest;
use BieProject\Belajar\PHP\LoginManage\Repository\SessionRepository;
use BieProject\Belajar\PHP\LoginManage\Repository\UserRepository;
use BieProject\Belajar\PHP\LoginManage\Service\SessionService;
use BieProject\Belajar\PHP\LoginManage\Service\UserService;

class UserController {
    private UserService $userService;
    private SessionService $sessionService; 
    

    public function __construct() {
        $connection = Database::getConnection();
        $userRepository = new UserRepository($connection);
        $this->userService = new UserService($userRepository);

        $sessionRepository = new SessionRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }


    //Menampilkan halaman registerasi
    public function register () {
        View::render('User/register', [
            'title' => 'Register new User'
        ]);
    }

    //Untuk menampilkan actionnya
    public function postRegister() {
        $request = new UserRegisterRequest();
        $request->id = $_POST['id'];
        $request->name = $_POST['name'];
        $request->password  = $_POST['password'];
        $request->school = $_POST['school'];
        $request->address = $_POST['address'];

        try{
            $this->userService->register($request);
            View::redirect('/users/login');
        }catch(ValidationException $exception) {
            View::render('User/register', [
                'title' => 'Register new User',
                'error' => $exception->getMessage()
            ]);
        }
    }

    //Untuk tampilan viewnya
    public function login() {
        View::render('User/login', [
            "title" => "Login Page"
        ]);
    }

    //Untuk actionnya
    public function postLogin() {
        $request = new UserLoginRequest();
        $request->id = $_POST["id"];
        $request->password = $_POST["password"];

        try {
            $response = $this->userService->login($request);
            $this->sessionService->create($response->user->id);
            View::redirect('/');
        }catch(ValidationException $exception) {
            View::render('User/login', [
                'title' => 'Login User',
                'error' => $exception->getMessage()
            ]);
        }
    }

    //Untuk Fungsi logout
    public function logout() {
        $this->sessionService->destroy();
        View::redirect('/');
    }

    //Untuk tampilan view
    public function updateProfile() {
        $user = $this->sessionService->current();

        View::render('User/profile', [
            "title" => "Update User Profile",
            "user" => [
                "id" => $user->id,
                "name" => $user->name,
            ]
        ]);
    }

    public function postUpdateProfile() {
        $user = $this->sessionService->current();

        $request = new UserProfileUpdateRequest();
        $request->id = $user->id;
        $request->name = $_POST['name'];

        try{
            $this->userService->updateProfile($request);
            View::redirect('/');
        } catch(validationException $exception) {
            View::render('User/Profile', [
                "title" => "Update user Profile",
                "error" => $exception->getMessage(),
                "user" => [
                    "id" => $user->id,
                    "name"=> $_POST['name'],
                ]
            ]);
        }
    }

    //Untuk action dari fungsi update profile
}


?>