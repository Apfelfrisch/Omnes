<?php

namespace App\Service\Bus\Handler;

use App\Exceptions\NoPermissionExpection;
use Illuminate\Contracts\Auth\Access\Gate;
use App\Service\Acl\UserRole\UserRoleRepository;
use App\Service\Bus\Command\UserRoleDeleteCommand;

class UserRoleDeleteHandler
{
    private $gate;
    private $userRoleRepo;
    
    public function __construct(Gate $gate, UserRoleRepository $userRoleRepo)
    {
        $this->gate = $gate;
        $this->userRoleRepo = $userRoleRepo;
    }

    public function handle(UserRoleDeleteCommand $command)
    {
        $userRole = $this->userRoleRepo->find($command->id);

        $this->checkPermssion($userRole);
        
        $userRole->delete();
    }

    private function checkPermssion($userRole)
    {
        if ($this->gate->denies('save', $userRole)) {
            throw new NoPermissionExpection('Keine Berechtigung um Nutzerdaten zu verändern.');
        }
    }
}
