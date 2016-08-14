<?php

namespace App\Policies;

use App\Service\Acl\Role\RoleRepository;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeaguePolicy
{
    use HandlesAuthorization;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function leaveLeague($authUser, $league, $targetUser)
    {
        if ($league && $authUser->id == $targetUser->id) {
            return true;
        }

        $allowedRoles = $this->roleRepository->getAllWithPermission('change_user_role');

        return $authUser->hasRoleFor($allowedRoles, $league);
    }
}
