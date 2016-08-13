<?php

namespace App\Domain\Activity;

use App\Domain\League\League;
use App\Domain\Adress\Adress;
use App\Domain\Contact\Contact;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['description'];

    public function adress()
    {
        return $this->belongsTo(Adress::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function setAdress($adressData)
    {
        $this->adress()->associate(Adress::create($adressData));
    }

    public function setContact($contactData)
    {
        $this->contact()->associate(Contact::create($contactData));
    }

    public function addLeague($league)
    {
        $this->league()->associate($league);
    }
}
