<?php

namespace App\Service\Bus\Handler;

use App\Service\Bus\Command\AddRoleToUserCommand;
use App\Domain\User\Repositories\UserRepository;
use App\Domain\User\Repositories\RoleRepository;
use App\Domain\Repositories\CoordinatorRepository;

class AddRoleToUserHandler
{
    private $userRepo;
    private $roleRepo;
    private $coordinatorRepo;
    
    public function __construct(UserRepository $userRepo, RoleRepository $roleRepo, CoordinatorRepository $coordinatorRepo)
    {
        $this->userRepo = $userRepo;
        $this->roleRepo = $roleRepo;
        $this->coordinatorRepo = $coordinatorRepo;
    }

    public function handle(AddRoleToUserCommand $command)
    {
        $coordinator = $this->coordinatorRepo->find($command->coordinator_id);
        $authUser = $this->userRepo->authUser();
        if (! $authUser->hasRoleFor($this->getAdminRole(), $coordinator)) {
            echo 'No Admin Role';
        }

        $user = $this->userRepo->find($command->user_id);
        if (!$user->isMemberOf($coordinator)) {
            echo 'Eorror';
        }
        
        $role = $this->roleRepo->find($command->role_id);
        $user->addRole($role, $coordinator);
    }

    private function getAdminRole()
    {
        return $this->roleRepo->get('admin');
    }
}
