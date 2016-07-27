<?php

namespace App\Domain\User;

use Illuminate\Database\Eloquent\Model;
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
    }
}
