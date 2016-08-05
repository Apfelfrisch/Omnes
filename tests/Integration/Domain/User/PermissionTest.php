<?php

namespace Test\Integration\Domain\User;

use TestCase;
use App\Service\Acl\Role\Role;
use App\Service\Acl\Permission\Permission;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PermissionTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_adds_a_permission_to_a_role()
    {
        $role = factory(Role::class)->create();
        $permission = factory(Permission::class)->create();

        $role->givePermission($permission);

        $this->assertEquals($role->id, $permission->roles->first()->id);
    }
}
