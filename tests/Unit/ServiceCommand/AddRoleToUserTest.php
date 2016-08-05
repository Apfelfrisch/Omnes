<?php

namespace Test\Unit\ServiceCommand;

use TestCase;
use Mockery as m;
use App\Service\Acl\User\User;
use App\Service\Acl\Role\Role;
use App\Domain\League\League;
use App\Domain\League\LeagueRepository;
use App\Service\Bus\Command\AddRoleToUserCommand;
use App\Service\Bus\Handler\AddRoleToUserHandler;
use App\Service\Acl\Repositories\UserRepository;
use App\Service\Acl\Repositories\RoleRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddRoleToUserTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_adds_a_a_role_to_a_user()
    {
        $command = new AddRoleToUserCommand(1, 2, 3);
        $leagueRepo = $this->makeLeagueRepoMock(3);

        $hanlder = new AddRoleToUserHandler(
            $this->makeUserRepoMock(1, $leagueRepo), 
            $this->makeRoleRepoMock(2),
            $leagueRepo
        );

        $hanlder->handle($command);
    }

    private function makeUserRepoMock($id, $leagueRepo)
    {
        $user = factory(User::class)->create();
        $user->join($leagueRepo->find(1));

        $authUser = new User;
        $authUser->id = $id;

        return m::mock(UserRepository::class, function($mock) use ($user, $authUser) {
            $mock->shouldReceive('find')->andReturn($user);
            $mock->shouldReceive('authUser')->andReturn($authUser);
        });
    }
    
    private function makeRoleRepoMock($id)
    {
        $role = new Role;
        $role->id = $id;

        return m::mock(RoleRepository::class, function($mock) use ($role) {
            $mock->shouldReceive('get')->andReturn($role);
            $mock->shouldReceive('find')->andReturn($role);
        });
    }
    
    private function makeLeagueRepoMock($id)
    {
        $league = new League;
        $league->id = $id;
        $league->name = 'Name';

        return m::mock(LeagueRepository::class, function($mock) use ($league) {
            $mock->shouldReceive('find')->andReturn($league);
        });
    }
}
