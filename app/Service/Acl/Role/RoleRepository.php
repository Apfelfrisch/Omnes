<?php

namespace App\Service\Acl\Role;

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

    public function getAllWithPermission($permssion)
    {
        return Role::join('permissions', 'roles.id', '=', 'permissions.id')->whereRaw('permissions.name = ?', [$permssion])->get();
    }
}
