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

    public function update(User $user): User
    {
        $statement = $this->connection->prepare("UPDATE users SET name = ?, password = ? WHERE id = ?");
        $statement->execute([
            $user->name, $user->password, $user->id
        ]);
        return $user;
    }

    public function findById(string $id): ?User
    {
        $statement = $this->connection->prepare("SELECT id, name, password FROM users WHERE id = ?");
        $statement->execute([$id]);

        try {
            if ($row = $statement->fetch()) {
                $user = new User();
                $user->id = $row['id'];
                $user->name = $row['name'];
                $user->password = $row['password'];
                $user->email = $row['email'];
                $user->address = $row['address'];
                return $user;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function deleteAll(): void
    {
        $this->connection->exec("DELETE from users");
    }
}


?>