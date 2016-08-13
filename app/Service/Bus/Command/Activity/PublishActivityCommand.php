<?php

namespace App\Service\Bus\Command\Activity;

use Illuminate\Http\Request;

class PublishActivityCommand
{
    public $activity;
    public $contact;
    public $adress;
    
    public function __construct($request)
    {
        $this->activity['description'] = $request['description'];
        $this->activity['league_id'] = $request['league_id'];
        $this->contact = $request['contact'];
        $this->adress = $request['adress'];
    }
}
