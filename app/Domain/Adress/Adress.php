<?php

namespace App\Domain\Adress;

use Illuminate\Database\Eloquent\Model;

class Adress extends Model
{
    protected $fillable = ['street', 'number', 'zip', 'city'];
}
