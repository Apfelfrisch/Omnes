<?php

namespace Test\Integration\Domain\User;

use TestCase;
use App\Domain\User\User;
use App\Domain\User\Role;
use App\Domain\User\Permission;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Domain\Coordinator;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_adds_a_to_a_role()
    {
        $role = factory(Role::class)->create();
        $coordinator = factory(Coordinator::class)->create();
        $user = factory(User::class)->create();

        $user->join($coordinator);
        $user->addRole($role, $coordinator);
        
        $this->assertEquals($role->id, $user->rolesFor($coordinator)->first()->id);
    }

    /** @test */
    public function it_joins_a_coordinator()
    {
        $coordinator = factory(Coordinator::class)->create();
        $user = factory(User::class)->create();

        $user->join($coordinator);

        $this->assertEquals($coordinator->id, $user->coordinators->first()->id);
    }
    
    /** @test */
    public function it_checks_of_the_given_controller_role_is_associated()
    {
        $permissionRoles = factory(Role::class, 2)->create();
        $forbiddenRoles = factory(Role::class, 2)->create();

        $coordinator = factory(Coordinator::class)->create();
        $foreignCoordinator = factory(Coordinator::class)->create();

        $user = factory(User::class)->create();
        
        $user->join($coordinator);
        $user->addRole($permissionRoles[0], $coordinator);

        $this->assertTrue($user->hasRoleFor($permissionRoles, $coordinator));
        $this->assertTrue($user->hasRole($permissionRoles[0]));

        $this->assertFalse($user->hasRole($forbiddenRoles));
        $this->assertFalse($user->hasRoleFor($permissionRoles, $foreignCoordinator));
    }
}
