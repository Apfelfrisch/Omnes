<?php

namespace App\Domain;

use Illuminate\Database\Eloquent\Model;
use App\Domain\User\User;

class Coordinator extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
