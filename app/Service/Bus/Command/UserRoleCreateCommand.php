<?php

namespace App\Service\Bus\Command;

use Illuminate\Http\Request;

class UserRoleCreateCommand
{
    public $properties;
    
    public function __construct($properties)
    {
        $this->properties = $properties;
    }
}
