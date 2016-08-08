<?php

namespace App\Service\Acl\User;

use Exception;
use App\Domain\League\League;
use App\Service\Acl\Role\Role;
use App\Service\Acl\UserRole\UserRole;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Service\Acl\Permission\Permission;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function leagues()
    {
        return $this->belongsToMany(League::class);
    }

    public function join(League $league)
    {
        $this->leagues()->save($league);

        return $this;
    }

    public function roles()
    {
        return $this->hasManyThrough(Role::class, UserRole::class, 'role_id', 'id');
    }

    public function roleFor(League $league)
    {
        return $this->hasManyThrough(Role::class, UserRole::class, 'role_id', 'id')
            ->where(['league_id' => $league->id, 'user_id' => $this->id])
            ->first();
    }

    public function isMemberOf(League $league = null)
    {
        if ($league === null) {
            return false;
        }
        return !! $this->leagues()->find($league->id);
    }

    public function hasRoleFor($role, League $league = null)
    {
        if ($league == null) {
            return false;
        }
        if (null == $role = $this->roleFor($league)) {
            return false;
        }
        if ($role instanceof Collection) {
            return !! $role->where($this->roleFor($league)->id)->count();
        }

        return $role->id == $this->roleFor($league)->id;
    }

    public function hasRole($role)
    {
        if ($role instanceof Collection) {
            return !! $role->intersect($this->roles)->count();
        }
        return !! $this->roles->where('id', $role->id);
    }
}

