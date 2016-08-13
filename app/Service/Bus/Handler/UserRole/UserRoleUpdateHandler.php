<?php

namespace App\Service\Bus\Handler\UserRole;

use App\Exceptions\NoPermissionExpection;
use Illuminate\Contracts\Auth\Access\Gate;
use App\Service\Acl\UserRole\UserRoleRepository;
use App\Service\Bus\Command\UserRole\UserRoleUpdateCommand;

class UserRoleUpdateHandler
{
    private $gate;
    private $userRoleRepo;
    
    public function __construct(Gate $gate, UserRoleRepository $userRoleRepo)
    {
        $this->gate = $gate;
        $this->userRoleRepo = $userRoleRepo;
    }

    public function handle(UserRoleUpdateCommand $command)
    {
        $userRole = $this->userRoleRepo->find($command->id);

        $this->checkPermssion($userRole);
        
        $userRole->fill($command->properties);

        $userRole->save();
    }

    private function checkPermssion($userRole)
    {
        if ($this->gate->denies('save', $userRole)) {
            throw new NoPermissionExpection('Keine Berechtigung um Nutzerdaten zu verändern.');
        }
    }
}
