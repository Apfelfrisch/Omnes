<?php

namespace App\Service\Bus\Command;

use Illuminate\Http\Request;

class AddRoleToUserCommand
{
    public $userId;
    public $roleId;
    public $coordinatorId;
    
    public function __construct($userId, $roleId, $coordinatorId)
    {
        $this->user_id = $userId;
        $this->role_id = $roleId;
        $this->coordinator_id = $coordinatorId;
    }
}
