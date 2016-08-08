<?php

namespace App\Service\Acl\Role;

use Illuminate\Database\Eloquent\Model;
use App\Service\Acl\Permission\Permission;
use Illuminate\Database\Eloquent\Collection;

class Role extends Model
{
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function givePermission(Permission $permission)
    {
        $this->permissions()->save($permission);

        return $this;
    }
}
