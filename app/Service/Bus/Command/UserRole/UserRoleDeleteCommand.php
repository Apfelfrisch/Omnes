<?php

namespace App\Service\Bus\Command\UserRole;

use Illuminate\Http\Request;

class UserRoleDeleteCommand
{
    public $id;
    
    public function __construct($id)
    {
        $this->id = $id;
    }
}
