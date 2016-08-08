<?php

namespace App\Service\Acl\UserRole;

use Auth;

class UserRoleRepository
{
    public function find($id)
    {
        return UserRole::find($id);
    }
}
