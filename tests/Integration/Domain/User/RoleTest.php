<?php

namespace Test\Integration\Domain\User;

use TestCase;
use App\Domain\User\Role;
use App\Domain\User\Permission;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoleTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_adds_a_permission_to_a_role()
    {
        $role = factory(Role::class)->create();
        $permission = factory(Permission::class)->create();

        $role->givePermission($permission);

        $this->assertEquals($permission->id, $role->permissions->first()->id);
    }
}
