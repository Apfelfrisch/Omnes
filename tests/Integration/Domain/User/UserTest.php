<?php

namespace Test\Integration\Domain\User;

use TestCase;
use App\Domain\User\User;
use App\Domain\User\Role;
use App\Domain\User\Permission;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_adds_a_to_a_role_to_a_user()
    {
        $role = factory(Role::class)->create();
        $user = factory(User::class)->create();

        $user->addRole($role);

        $this->assertEquals($role->id, $user->roles->first()->id);
    }
    
    /** @test */
    public function it_checks_of_the_given_role_is_associated_with()
    {
        $permissionRoles = factory(Role::class, 2)->create();
        $forbiddenRoles = factory(Role::class, 2)->create();
        $user = factory(User::class)->create();
        
        $user->addRole($permissionRoles[0]);
        $user->addRole($permissionRoles[1]);

        $this->assertTrue($user->hasRole($permissionRoles));
        $this->assertTrue($user->hasRole($permissionRoles[0]));
        $this->assertTrue($user->hasRole($permissionRoles[1]));

        $this->assertFalse($user->hasRole($forbiddenRoles));
        $this->assertFalse($user->hasRole($forbiddenRoles[0]));
        $this->assertFalse($user->hasRole($forbiddenRoles[1]));

    }
}
