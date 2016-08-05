<?php

namespace App\Service\Bus\Handler;

use App\Domain\League\LeagueRepository;
use App\Service\Acl\Repositories\UserRepository;
use App\Service\Acl\Repositories\RoleRepository;
use App\Service\Bus\Command\AddRoleToUserCommand;
use App\Service\Acl\UserRole\UserRole;

class AddRoleToUserHandler
{
    private $userRepo;
    
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function handle(AddRoleToUserCommand $command)
    {
        $userRole = new UserRole([
            'user_id' => $command->user_id,
            'role_id' => $command->role_id,
            'league_id' => $command->league_id,
        ]);

        $this->checkPermssion($userRole);
        
        $userRole->save();
    }

    private function checkPermssion($userRole)
    {
        if ($this->userRepo->authUser()->cannot('update', $userRole)) {
            throw new \Exception('No Permission');
        }
    }
}
