<?php 

namespace BieProject\Belajar\PHP\LoginManage\Repository;

use BieProject\Belajar\PHP\LoginManage\Domain\User;

class UserRepository {
    private \PDO $connection;

    public function __construct(\PDO $connection) {
        $this->connection = $connection;
    }

    public function save(User $user): User {
        $statement = $this->connection->prepare("INSERT INTO users(id, name, password, email, adress) VALUES(?, ?, ?, ?, ?)");
        $statement->execute([
            $user-> id, $user->name, $user->password, $user->email, $user->address,
        ]);
        return $user;
    }
}


?>