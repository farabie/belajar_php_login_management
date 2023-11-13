<?php

namespace BieProject\Belajar\PHP\LoginManage\Service;


use BieProject\Belajar\PHP\LoginManage\Domain\Session;
use BieProject\Belajar\PHP\LoginManage\Domain\User;
use BieProject\Belajar\PHP\LoginManage\Repository\SessionRepository;
use BieProject\Belajar\PHP\LoginManage\Repository\UserRepository;


class SessionService
{
    public static string $COOKIE_NAME = "X-BIE-SESSION";

    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    public function __construct(SessionRepository $sessionRepository, UserRepository $userRepository)
    {
        $this->sessionRepository = $sessionRepository;
        $this->userRepository = $userRepository;
    }

    public function create(string $userId): Session {
        $session = new Session();
        $session->id = uniqid();
        $session->userId = $userId;

        $this->sessionRepository->save($session);
        //Set cookienya yaitu 30 hari untuk time() itu waktu saat ini
        //Perhitungan waktunya (60(detik) * 60(menit) * 24(jam) * 30 (hari))
        setcookie(self::$COOKIE_NAME, $session->id, time() + (60 * 60 * 24 * 30), "/");

        return $session;
    }

    public function destroy() {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? '';
        $this->sessionRepository->deleteById($sessionId);

        setcookie(self::$COOKIE_NAME, '', 1, "/");
    }

    public function current(): ?User {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? '';
        $session = $this->sessionRepository->findById($sessionId);
        if($session == null) {
            return null;
        }

        return $this->userRepository->findById($session->userId); 
    }
}
