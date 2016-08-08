<?php

namespace App\Domain\League;

use App\Domain\League\League;

class LeagueRepository
{
    public function find($id)
    {
        return League::find($id);
    }

    public function allForUser($user)
    {
        return League::with('users')
            ->join('league_user', 'leagues.id', '=', 'league_user.league_id')
            ->where('league_user.user_id', '=', $user->id)
            ->get();
    }
}
