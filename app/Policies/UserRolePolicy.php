<?php

namespace App\Policies;

use App\Domain\League\LeagueRepository;
use App\Service\Acl\Role\RoleRepository;
use App\Service\Acl\User\UserRepository;
use Illuminate\Auth\Access\HandlesAuthorization;

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

    public function save($user, $userRole)
    {
        $allowedRoles = $this->roleRepository->getAllWithPermission('change_user_role');

        return $user->hasRoleFor($allowedRoles, $userRole->league);
    }
}
