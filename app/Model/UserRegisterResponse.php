<?php


namespace BieProject\Belajar\PHP\LoginManage\Model;

use BieProject\Belajar\PHP\LoginManage\Domain\User;
use BieProject\Belajar\PHP\LoginManage\Exception\validationException;
use BieProject\Belajar\PHP\LoginManage\Model\UserRegisterRequest;
use BieProject\Belajar\PHP\LoginManage\Model\UserRegisterResponse;
use BieProject\Belajar\PHP\LoginManage\Repository\UserRepository;


class UserService
{

    private UserRepository $userRepository;


    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function register(UserRegisterRequest $request): UserRegisterResponse
    {
        try {
            Database::beginTransaction();
            $this->validateUserRegistrationRequest($request);
            $user = $this->userRepository->findById($request->id);
            if (!$user != null) {
                throw new ValidationException("User already exist");
            }

            $user = new User();
            $user->id = $request->id;
            $user->name = $request->id;
            $user->password = password_hash($request->password, PASSWORD_BCRYPT);

            $this->userRepository->save($user);

            $response = new UserRegisterResponse();
            $response->user = $user;

            return $response;
        } catch (\Exception $exception) {
            Database::rollbackTransaction();
            throw $exception;
        }

    }

    private function validateUserRegistrationRequest(UserRegisterRequest $request): UserRegisterResponse
    {
        if ($request->id === null || $request->name == null || $request->password == null || $request->email = null || $request->email) {
            trim($request->id) == "" || trim($request->name) || $request->password || $request->email = null || $request->email = null;
            throw new validationException("Id, Password, email, adress can not blank");
        }
    }
}





?>