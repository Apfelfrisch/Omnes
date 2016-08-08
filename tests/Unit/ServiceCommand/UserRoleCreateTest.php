<?php

namespace Test\Unit\ServiceCommand;

use TestCase;
use Mockery as m;
use App\Service\Acl\UserRole\UserRole;
use App\Exceptions\NoPermissionExpection;
use Illuminate\Contracts\Auth\Access\Gate;
use App\Service\Bus\Command\UserRoleCreateCommand;
use App\Service\Bus\Handler\UserRoleCreateHandler;

class UserRoleCreateTest extends TestCase
{
    /** @test */
    public function it_adds_a_new_user_role()
    {
        $rolePoperties = [
            'user_id' => 1, 'role_id' => 2, 'league_id' => 3
        ];
        $userRole = m::mock(UserRole::class)->makePartial()->shouldReceive('save')->once()->getMock();

        $hanlder = new UserRoleCreateHandler($this->makeGateWichAllowsPermission(), $userRole);
        $hanlder->handle(new UserRoleCreateCommand($rolePoperties));

        $this->assertEquals($rolePoperties['user_id'], $userRole->user_id);
        $this->assertEquals($rolePoperties['role_id'], $userRole->role_id);
        $this->assertEquals($rolePoperties['league_id'], $userRole->league_id);
    }

    /** @test */
    public function it_throws_an_expection_if_user_has_no_permssion_to_add_a_role()
    {
        $rolePoperties = [
            'user_id' => 1, 'role_id' => 2, 'league_id' => 3
        ];
        $userRole = m::mock(UserRole::class)->makePartial()->shouldReceive('save')->getMock();

        $hanlder = new UserRoleCreateHandler($this->makeGateWichDeniesPermission(), $userRole);

        $this->expectException(NoPermissionExpection::class);
        $hanlder->handle(new UserRoleCreateCommand($rolePoperties));
    }

    private function makeGateWichAllowsPermission()
    {
        return $this->makeGate($allow = true);
    }

    private function makeGateWichDeniesPermission()
    {
        return $this->makeGate($allow = false);
    }

    private function makeGate($allow)
    {
        return m::mock(Gate::class)
            ->shouldReceive('denies')->andReturn($allow == false)
            ->shouldReceive('allows')->andReturn($allow)
            ->getMock();
    }
}
