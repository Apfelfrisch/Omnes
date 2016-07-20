<?php

namespace App\ServiceBus\LoginUser;

use Illuminate\Http\Request;

class LoginUserCommand
{
    public $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
