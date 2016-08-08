<?php

namespace App\Service\Acl\User;

use Auth;

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
