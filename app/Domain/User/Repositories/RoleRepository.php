<?php

namespace App\Domain\User\Repositories;

use App\Domain\User\Role;

class RoleRepository
{
    public function find($id)
    {
        return Role::find($id);
    }

    public function get($name)
    {
        return Role::where('name', '=', $name)->firstOrFail();
    }
}
