<?php

namespace App\Service\Bus\Command;

use Illuminate\Http\Request;

class UserRoleUpdateCommand
{
    public $id;
    public $properties;
    
    public function __construct($id, $properties)
    {
        $this->id = $id;
        $this->properties = $properties;
    }
}
