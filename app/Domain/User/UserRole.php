<?php

namespace App\Domain\User;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $fillable = [
        'user_id', 'role_id', 'coordinator_id',
    ];
}
