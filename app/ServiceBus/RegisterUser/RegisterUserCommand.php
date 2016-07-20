<?php

namespace App\ServiceBus\RegisterUser;

use Illuminate\Http\Request;

class RegisterUserCommand
{
    public $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
