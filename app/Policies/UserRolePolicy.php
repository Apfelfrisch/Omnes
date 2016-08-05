<?php

namespace App\Policies;

use App\Domain\League\LeagueRepository;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Service\Acl\Repositories\RoleRepository;
use App\Service\Acl\Repositories\UserRepository;

class UserRolePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function update($user, $userRole)
    {
        if (!$userRole->user->isMemberOf($userRole->league)) {
            return false;
        }

        $allowedRoles = $this->roleRepository->getAllWithPermission('update_user_role');

        return $user->hasRole($allowedRoles, $userRole->league);
    }
}
