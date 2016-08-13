<?php

namespace Test\Unit\ServiceCommand;

use TestCase;
use Mockery as m;
use App\Service\Acl\UserRole\UserRole;
use App\Exceptions\NoPermissionExpection;
use App\Service\Acl\UserRole\UserRoleRepository;
use App\Service\Bus\Command\UserRole\UserRoleCreateCommand;
use App\Service\Bus\Handler\UserRole\UserRoleCreateHandler;

class UserRoleCreateTest extends TestCase
{
    /** @test */
    public function it_adds_a_new_user_role()
    {
        $rolePoperties = [
            'user_id' => 1, 'role_id' => 2, 'league_id' => 3
        ];
        $userRoleRepo = $this->makeUserRoleRepoMock(
            $userRole = $this->makeUserRoleMock('save', 'once')
        );

        $handler = new UserRoleCreateHandler($this->makeGateWichAllowsPermission(), $userRoleRepo);
        $handler->handle(new UserRoleCreateCommand($rolePoperties));

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
        $userRoleRepo = $this->makeUserRoleRepoMock(
            $userRole = $this->makeUserRoleMock('save', 'never')
        );

        $handler = new UserRoleCreateHandler($this->makeGateWichDeniesPermission(), $userRoleRepo);

        $this->expectException(NoPermissionExpection::class);
        $handler->handle(new UserRoleCreateCommand($rolePoperties));
    }

    private function makeUserRoleMock($method = 'save', $count = 'once')
    {
        return m::mock(UserRole::class)
            ->makePartial()
            ->shouldReceive($method)->$count()
            ->getMock();
    }
    
    private function makeUserRoleRepoMock($userRole)
    {
        return m::mock(UserRoleRepository::class)
            ->shouldReceive('firstOrAdd')
            ->andReturn($userRole)
            ->getMock();
    }

}
