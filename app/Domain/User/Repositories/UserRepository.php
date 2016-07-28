<?php

namespace App\Domain\User\Repositories;

use Auth;
use App\Domain\User\User;

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
}
