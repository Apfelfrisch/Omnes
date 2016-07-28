<?php

namespace App\Domain\User;

use Exception;
use App\Domain\Coordinator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function coordinators()
    {
        return $this->belongsToMany(Coordinator::class);
    }

    public function join(Coordinator $coordinator)
    {
        return $this->coordinators()->save($coordinator);
    }

    public function rolesFor(Coordinator $coordinator)
    {
        return $this->roles($coordinator);
    }

    public function roles(Coordinator $coordinator = null)
    {
        $query = $this->hasManyThrough(Role::class, UserRole::class, 'role_id', 'id');
        if ($coordinator) {
            $query->where('coordinator_id', $coordinator->id);
        }
        return $query->get();
    }

    public function isMemberOf(Coordinator $coordinator)
    {
        return !! $this->coordinators()->find($coordinator->id);
    }

    public function hasRoleFor($role, Coordinator $coordinator)
    {
        return $this->hasRole($role, $coordinator);
    }

    public function hasRole($role, Coordinator $coordinator = null)
    {
        if ($role instanceof Collection) {
            return !! $role->intersect($this->roles($coordinator))->count();
        }
        return !! $this->roles($coordinator)->find($role->id);
    }
    
    public function addRole(Role $role, Coordinator $coordinator)
    {
        if (!$this->isMemberOf($coordinator)) {
            throw new Exception("Benutzter nicht Mitglied des Koordinators $coordinator->name");
        }
        UserRole::create([
            'user_id' => $this->id,
            'role_id' => $role->id,
            'coordinator_id' => $coordinator->id,
        ]);
    }
}
