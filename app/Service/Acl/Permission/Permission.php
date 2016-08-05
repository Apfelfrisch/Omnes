<?php

namespace App\Service\Acl\Permission;

use App\Service\Acl\Role\Role;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
