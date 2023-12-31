<?php

namespace BieProject\Belajar\PHP\LoginManage\Service;

use BieProject\Belajar\PHP\LoginManage\Config\Database;
use BieProject\Belajar\PHP\LoginManage\Domain\User;
use BieProject\Belajar\PHP\LoginManage\Exception\validationException;
use BieProject\Belajar\PHP\LoginManage\Model\UserLoginRequest;
use BieProject\Belajar\PHP\LoginManage\Model\UserLoginResponse;
use BieProject\Belajar\PHP\LoginManage\Model\UserPasswordUpdateRequest;
use BieProject\Belajar\PHP\LoginManage\Model\UserPasswordUpdateResponse;
use BieProject\Belajar\PHP\LoginManage\Model\UserProfileUpdateRequest;
use BieProject\Belajar\PHP\LoginManage\Model\UserProfileUpdateResponse;
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
            $user->school = $request->school;
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
            $request->id == null || $request->name == null || $request->password == null || $request->school = null || trim($request->id) == ""
            || trim($request->name) == "" || trim($request->password) == "" || trim($request->address) == ""
        ) {
            throw new ValidationException("Id, Name, Password, school, Adress can not blank");
        }
    }


    public function login(UserLoginRequest $request):UserLoginResponse {
        $this->validateUserLoginRequest($request);

        $user = $this->userRepository->findById($request->id);
        if($user == null) {
            throw new ValidationException("Id or Password is wrong");
        }

        if(password_verify($request->password, $user->password)) {
            $response = new UserLoginResponse();
            $response->user = $user;
            return $response;
        }else {
            throw new ValidationException("Id or Password is worng");
        }
    }
    private function validateUserLoginRequest(UserLoginRequest $request)
    {
        if (
            $request->id == null ||  $request->password == null || trim($request->id) == ""
            || trim($request->password) == ""
        ) {
            throw new ValidationException("Id, Password can not blank");
        }
    }

    public function updateProfile(UserProfileUpdateRequest $request): UserProfileUpdateResponse {
        $this->validateUserProfileUpdateRequest($request);

        try{
            Database::beginTransaction();

            $user = $this->userRepository->findById($request->id);
            if($user == null) {
                throw new ValidationException("User is not found");
            }

            $user->name = $request->name;
            $this->userRepository->update($user);

            Database::commitTransaction();

            $response = new UserProfileUpdateResponse();
            $response->user = $user;
            return $response;

        }catch(\Exception $exception) {
            Database::rollbackTransaction();
            throw $exception;
        }
    }

    private function validateUserProfileUpdateRequest(UserProfileUpdateRequest $request) {
        if($request->id == null || $request->name == null || trim($request-> id) == "" || trim($request->name) == "" ) {
            throw new validationException("Id, Name can not blank");
        }
    }


    public function updatePassword(UserPasswordUpdateRequest $request): UserPasswordUpdateResponse {
        $this->validateUpdatePasswordRequest($request);

        try{
            Database::beginTransaction();

            $user = $this->userRepository->findById($request->id);
            if($user == null) {
                throw new ValidationException("User is not found");
            }

            if(!password_verify($request->oldPassword, $user->password)) {
                throw new ValidationException("Old Password is wrong");
            }

            $user->password = password_hash($request->newPassword, PASSWORD_BCRYPT);
            $this->userRepository->update($user);

            Database::commitTransaction();

            $response = new UserPasswordUpdateResponse();
            $response->user = $user;
            return $response;
            
        }catch(\Exception $exception) {
            Database::rollbackTransaction();
            throw $exception;
        }

    }

    public function validateUpdatePasswordRequest(UserPasswordUpdateRequest $request) {
        if ($request->id == null || $request->oldPassword == null || $request->newPassword == null || trim($request->id) == "" || trim($request->oldPassword) == ""|| trim($request->newPassword) == "" ) {
            throw new validationException("Id, Old Password, New Password can not blank");
        }
    }
}
