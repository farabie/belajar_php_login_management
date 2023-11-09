<?php 

namespace BieProject\Belajar\PHP\LoginManage\Controller;

class ProductController {
    function categories(string $productId, string $categoryId): void {
        echo "PRODUCT: $productId, CATEGORY: $categoryId";
    }
}

?>