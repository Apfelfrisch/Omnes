<?php

namespace App\Domain\League;

use App\Domain\League\League;

class LeagueRepository
{
    public function find($id)
    {
        return League::find($id);
    }
}
