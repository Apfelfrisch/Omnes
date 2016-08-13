<?php

namespace App\Service\Bus\Handler\UserRole;

use App\Service\Acl\UserRole\UserRole;
use App\Exceptions\NoPermissionExpection;
use Illuminate\Contracts\Auth\Access\Gate;
use App\Service\Acl\UserRole\UserRoleRepository;
use App\Service\Bus\Command\UserRole\UserRoleCreateCommand;

class UserRoleCreateHandler
{
    private $gate;
    private $userRoleRepo;
    
    public function __construct(Gate $gate, UserRoleRepository $userRoleRepo)
    {
        $this->gate = $gate;
        $this->userRoleRepo = $userRoleRepo;
    }

    public function handle(UserRoleCreateCommand $command)
    {
        $userRole = $this->userRoleRepo->firstOrAdd($command->properties);
        $userRole->fill($command->properties);
        $this->checkPermssion($userRole);
        
        $userRole->save();
    }

    private function checkPermssion($userRole)
    {
        if ($this->gate->denies('save', $userRole)) {
            throw new NoPermissionExpection('Keine Berechtigung um Nutzerdaten zu verändern.');
        }
    }
}
