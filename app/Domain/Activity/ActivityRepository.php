<?php

namespace App\Domain\Activity;

use App\Domain\League\League;
use App\Domain\Activity\Activity;
use App\Domain\Adress\Adress;
use App\Domain\Contact\Contact;

class ActivityRepository
{
    public function find($id)
    {
        return Activity::find($id);
    }

    public function create($properties)
    {
        return new Activity($properties);
    }

    public function persist(Activity $activity)
    {
        $activity->push();

        return $activity;
    }
    
}
