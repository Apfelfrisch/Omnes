<?php

namespace App\Policies;

use App\Service\Acl\Role\RoleRepository;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserRolePolicy
{
    use HandlesAuthorization;

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
