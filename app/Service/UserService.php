<?php

namespace BieProject\Belajar\PHP\LoginManage\Service;

use BieProject\Belajar\PHP\LoginManage\Config\Database;
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
        $this->validateUserRegistrationRequest($request);
        try {
            Database::beginTransaction();
            $user = $this->userRepository->findById($request->id);
            if ($user != null) {
                throw new ValidationException("User Id already exists");
            }

            $user = new User();
            $user->id = $request->id;
            $user->name = $request->name;
            $user->password = password_hash($request->password, PASSWORD_BCRYPT);
            $user->email = $request->email;
            $user->address = $request->address;

            $this->userRepository->save($user);

            $response = new UserRegisterResponse();
            $response->user = $user;

            Database::commitTransaction();
            return $response;
        } catch (\Exception $exception) {
            Database::rollbackTransaction();
            throw $exception;
        }
    }

    private function validateUserRegistrationRequest(UserRegisterRequest $request)
    {
        if (
            $request->id == null || $request->name == null || $request->password == null ||
            $request->address == null || $request->email == null || trim($request->id) == ""
            || trim($request->name) == "" || trim($request->password) == "" || trim($request->email)
            == "" || trim($request->address)
        ) {
            throw new validationException("Id, Name, Password, Email, Adress can not blank");
        }
    }
}