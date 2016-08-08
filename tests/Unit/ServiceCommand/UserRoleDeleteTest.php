<?php

namespace Test\Unit\ServiceCommand;

use TestCase;
use Mockery as m;
use App\Service\Acl\UserRole\UserRole;
use App\Exceptions\NoPermissionExpection;
use Illuminate\Contracts\Auth\Access\Gate;
use App\Service\Acl\UserRole\UserRoleRepository;
use App\Service\Bus\Command\UserRoleDeleteCommand;
use App\Service\Bus\Handler\UserRoleDeleteHandler;

class UserRoleDeleteTest extends TestCase
{
    /** @test */
    public function it_deletes_a_user_role()
    {
        $userRoleId = 1;
        $userRoleRepo = $this->makeUserRoleRepoMock(
            $userRole = $this->makeUserRoleMock()
        );

        $hanlder = new UserRoleDeleteHandler($this->makeGateWichAllowsPermission(), $userRoleRepo);
        $hanlder->handle(new UserRoleDeleteCommand($userRoleId));
    }

    /** @test */
    public function it_throws_an_expection_if_user_has_no_permssion_to_update_a_role()
    {
        $userRoleId = 1;
        $userRoleRepo = $this->makeUserRoleRepoMock('');

        $hanlder = new UserRoleDeleteHandler($this->makeGateWichDeniesPermission(), $userRoleRepo);

        $this->expectException(NoPermissionExpection::class);
        $hanlder->handle(new UserRoleDeleteCommand($userRoleId));
    }
    
    private function makeUserRoleMock()
    {
        return m::mock(UserRole::class)
            ->shouldReceive('delete')->once()
            ->getMock();
    }
    
    private function makeUserRoleRepoMock($userRole)
    {
        return m::mock(UserRoleRepository::class)
            ->shouldReceive('find')
            ->andReturn($userRole)
            ->getMock();
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
