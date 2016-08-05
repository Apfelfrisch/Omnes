<?php

namespace App\Service\Bus\Command;

use Illuminate\Http\Request;

class AddRoleToUserCommand
{
    public $userId;
    public $roleId;
    public $leagueId;
    
    public function __construct($userId, $roleId, $leagueId)
    {
        $this->user_id = $userId;
        $this->role_id = $roleId;
        $this->league_id = $leagueId;
    }
}
