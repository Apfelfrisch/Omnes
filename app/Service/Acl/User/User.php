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
        return $this->leagues()->save($league);
    }

    public function roles(League $league = null)
    {
        $query = $this->hasManyThrough(Role::class, UserRole::class, 'role_id', 'id');
        if ($league) {
            $query->where(['league_id' => $league->id, 'user_id' => $this->id]);
        }
        return $query->get();
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
        return $league && $this->hasRole($role, $league);
    }

    public function hasRole($role, League $league = null)
    {
        if ($role instanceof Collection) {
            return !! $role->intersect($this->roles($league))->count();
        }
        return !! $this->roles($league)->find($role->id);
    }
}

