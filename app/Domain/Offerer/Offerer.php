<?php

namespace App\Domain\Offerer;

use App\Domain\Adress\Adress;
use App\Domain\Contact\Contact;
use Illuminate\Database\Eloquent\Model;

class Offerer extends Model
{
    public function adress()
    {
        return $this->belongsTo(Adress::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
