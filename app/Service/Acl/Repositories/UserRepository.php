<?php

namespace App\Service\Acl\Repositories;

use Auth;
use App\Service\Acl\User\User;

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
