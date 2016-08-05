<?php

namespace App\Domain\League;

use App\Service\Acl\User\User;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
