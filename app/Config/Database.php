<?php 

namespace BieProject\Belajar\PHP\LoginManage\Config;


class Database {
    private static ?\PDO $pdo = null;

    public static function getConnection(string $env = "test"): \PDO {
        if(self::$pdo == null) {
            //Create new PDO
            require_once __DIR__ . '../../config/database.php';
            $config = getDatabaseConfig();
            $self::$pdo = new \PDO(
                $config['database'][$env]['url'],
                $config['database'][$env]['username'],
                $config['database'][$env]['password'],
            );
        }else {
            return self::$pdo;
        }
    }
}


?>