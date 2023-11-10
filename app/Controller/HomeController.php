<?php

namespace BieProject\Belajar\PHP\LoginManage\Controller;

use BieProject\Belajar\PHP\LoginManage\APP\View;


class HomeController
{
    function index() {
        View::render('Home/index', [
            "title" => "PHP Login Management"
        ]);
    }

}



?>