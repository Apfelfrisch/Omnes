<?php

namespace App\Service\Acl\UserRole;

use App\Domain\League\League;
use Illuminate\Database\Eloquent\Model;
use App\Service\Acl\User\User;
use App\Service\Acl\Role\Role;
use App\Exceptions\InvalidUserRoleExpection;

class UserRole extends Model
{
    protected $fillable = [
        'user_id', 'role_id', 'league_id',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function($userRole)
        {
            $userRole->validate();

            return true;
        });
    }

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function validate()
    {
        if (!$user = $this->user()->find($this->user_id)) {
            throw InvalidUserRoleExpection::invalidUserGiven();
        }
        if (!$league = $this->league()->find($this->league_id)) {
            throw InvalidUserRoleExpection::invalidLeagueGiven();
        }
        if (!$this->role()->find($this->role_id)) {
            throw InvalidUserRoleExpection::invalidRoleGiven();
        }
        if (!$user->isMemberOf($league) ) {
            throw InvalidUserRoleExpection::userNotInLeague($this->user->name, $this->league->name);
        }
    }
}
