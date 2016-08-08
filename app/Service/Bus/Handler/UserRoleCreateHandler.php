<?php

namespace App\Service\Bus\Handler;

use App\Service\Acl\UserRole\UserRole;
use App\Exceptions\NoPermissionExpection;
use Illuminate\Contracts\Auth\Access\Gate;
use App\Service\Bus\Command\UserRoleCreateCommand;

class UserRoleCreateHandler
{
    private $gate;
    
    public function __construct(Gate $gate, UserRole $userRole)
    {
        $this->gate = $gate;
        $this->userRole = $userRole;
    }

    public function handle(UserRoleCreateCommand $command)
    {
        $this->userRole->fill($command->properties);

        $this->checkPermssion($this->userRole);
        
        $this->userRole->save();
    }

    private function checkPermssion($userRole)
    {
        if ($this->gate->denies('save', $userRole)) {
            throw new NoPermissionExpection('Keine Berechtigung um Nutzerdaten zu verändern.');
        }
    }
}
