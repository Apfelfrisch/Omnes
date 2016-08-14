<?php

namespace App\Policies;

use App\Service\Acl\Role\RoleRepository;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActivityPolicy
{
    use HandlesAuthorization;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function save($user, $activity)
    {
        $allowedRoles = $this->roleRepository->getAllWithPermission('publish_article');

        return $user->hasRoleFor($allowedRoles, $activity->league);
    }
}
