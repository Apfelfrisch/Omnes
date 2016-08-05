<?php

namespace App\Service\Acl\UserRole;

use App\Domain\League\League;
use Illuminate\Database\Eloquent\Model;
use App\Service\Acl\User\User;
use App\Service\Acl\Role\Role;

class UserRole extends Model
{
    protected $fillable = [
        'user_id', 'role_id', 'league_id',
    ];

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
}
