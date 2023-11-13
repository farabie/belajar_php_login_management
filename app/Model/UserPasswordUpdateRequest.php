<?php 

namespace BieProject\Belajar\PHP\LoginManage\Model;

class UserPasswordUpdateRequest {
    public ?string $id = null;	
    public ?string $oldPassword = null;
    public ?string $newPassword = null;
}


?>