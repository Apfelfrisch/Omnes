<?php

namespace App\Service\Bus\Command\League;

use Illuminate\Http\Request;

class LeaveLeagueCommand
{
    public $userId;
    public $leagueId;
    
    public function __construct($userId, $leagueId)
    {
        $this->userId = $userId;
        $this->leagueId = $leagueId;
    }
}
