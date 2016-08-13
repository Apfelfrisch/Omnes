<?php

namespace App\Domain\Contact;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['first_name', 'last_name', 'fax', 'mail', 'phone', 'mobile', 'twitter', 'facebook'];
}
