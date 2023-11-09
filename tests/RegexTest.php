<?php 

namespace BieProject\Belajar\PHP\MVC;

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/vendor/autoload.php";

class RegexTest extends TestCase {
    public function TestRege() {
        $path = "/products/1234/categories/abcde";

        //Awal dan akhir tidak menggunakan / karena / banyak digunakan oleh url

        $pattern = "#^/products/([0-9a-zA-Z]*)/categories/([0-9a-zA-Z]*)$#";
        

        $result = preg_match($pattern, $path, $variables);

        self::assertEquals(1, $result);

        var_dump($variables);
    }
}


?>