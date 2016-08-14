<?php

namespace App\Service\Acl\User;

use Auth;
use App\Domain\League\League;

class UserRepository
{
    public function authUser()
    {
        return Auth::user();
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function findOrFail($id)
    {
        return User::findOrFail($id);
    }
}
