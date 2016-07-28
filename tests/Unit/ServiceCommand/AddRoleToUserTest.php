<?php

namespace Test\Unit\ServiceCommand;

use TestCase;
use Mockery as m;
use App\Service\Bus\Command\AddRoleToUserCommand;
use App\Service\Bus\Handler\AddRoleToUserHandler;
use App\Domain\User\Repositories\UserRepository;
use App\Domain\User\Repositories\RoleRepository;
use App\Domain\Repositories\CoordinatorRepository;
use App\Domain\User\User;
use App\Domain\User\Role;
use App\Domain\Coordinator;

class AddRoleToUserTest extends TestCase
{
    /** @test */
    public function it_adds_a_a_role_to_a_user()
    {
        $command = new AddRoleToUserCommand(1, 2, 3);

        $hanlder = new AddRoleToUserHandler(
            $this->makeUserRepoMock(1), 
            $this->makeRoleRepoMock(2),
            $this->makeCoordinatorRepoMock(3)
        );

        $hanlder->handle($command);
    }

    private function makeUserRepoMock($id)
    {
        $user = new User;
        $user->id = $id;

        return m::mock(UserRepository::class, function($mock) use ($user) {
            $mock->shouldReceive('find')->andReturn($user);
        });
    }
    
    private function makeRoleRepoMock($id)
    {
        $role = new Role;
        $role->id = $id;

        return m::mock(RoleRepository::class, function($mock) use ($role) {
            $mock->shouldReceive('find')->andReturn($role);
        });
    }
    
    private function makeCoordinatorRepoMock($id)
    {
        $coordinator = new Coordinator;
        $coordinator->id = $id;

        return m::mock(CoordinatorRepository::class, function($mock) use ($coordinator) {
            $mock->shouldReceive('find')->andReturn($coordinator);
        });
    }
}
