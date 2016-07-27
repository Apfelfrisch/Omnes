<?php

namespace App\Service\Bus\Command;

use Illuminate\Http\Request;

class RegisterUserCommand
{
    public $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
