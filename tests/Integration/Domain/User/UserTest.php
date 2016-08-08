<?php

namespace Test\Integration\Domain\User;

use TestCase;
use App\Service\Acl\User\User;
use App\Service\Acl\Role\Role;
use App\Domain\League\League;
use App\Service\Acl\Permission\Permission;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Service\Acl\UserRole\UserRole;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_joins_a_league()
    {
        $league = factory(League::class)->create();
        $user = factory(User::class)->create();

        $user->join($league);

        $this->assertEquals($league->id, $user->leagues->first()->id);
    }
    
    /** @test */
    public function it_checks_of_the_given_controller_role_is_associated()
    {
        $permissionRoles = factory(Role::class, 2)->create();
        $forbiddenRoles = factory(Role::class, 2)->make();

        $league = factory(League::class)->create();
        $foreignLeague = factory(League::class)->make();

        $user = factory(User::class)->create();
        $user->join($league);

        $userRole = new UserRole([
            'user_id' => $user->id,
            'league_id' => $league->id,
            'role_id' => $permissionRoles[0]->id,
        ]);
        $userRole->save();

        $this->assertTrue($user->hasRoleFor($permissionRoles, $league));
        $this->assertTrue($user->hasRole($permissionRoles[0]));

        $this->assertFalse($user->hasRole($forbiddenRoles));
        $this->assertFalse($user->hasRoleFor($permissionRoles, $foreignLeague));
    }
}
