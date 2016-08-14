<?php

namespace Tests\Unit\ServiceCommand\League;

use TestCase;
use Mockery as m;
use App\Service\Acl\User\User;
use App\Service\Acl\User\UserRepository;
use App\Service\Bus\Command\League\LeaveLeagueCommand;
use App\Service\Bus\Handler\League\LeaveLeagueHandler;
use App\Domain\League\LeagueRepository;
use App\Domain\League\League;
use App\Exceptions\NoPermissionExpection;

class LeaveLeagueTest extends TestCase
{
    private $userId;
    private $groupId;

    public function setUp()
    {
        $this->userId = 1;
        $this->leagueId = 2;
    }
    
    /** @test */
    public function it_kicks_a_user_out_of_a_league()
    {
        $gate = $this->makeGateWichAllowsPermission();
        $userRepo = $this->makeUserRepoMock($user = $this->makeUserMock());
        $leagueRepo = $this->makeLeagueRepoMock($league = $this->makeLeagueMock());
        
        $handler = new LeaveLeagueHandler($gate, $userRepo, $leagueRepo);
        $handler->handle(new LeaveLeagueCommand(1, 2));
        
        $gate->shouldHaveReceived('denies')->with('leaveLeague', [$league, $user])->once();
        $user->shouldHaveReceived('leave')->with($league)->once();
    }

    /** @test */
    public function it_throws_an_expection_if_user_has_no_permssion_to_kick_a_user_out_of_a_league()
    {
        $gate = $this->makeGateWichDeniesPermission();
        $userRepo = $this->makeUserRepoMock($user = $this->makeUserMock());
        $leagueRepo = $this->makeLeagueRepoMock($league = $this->makeLeagueMock());
        
        $handler = new LeaveLeagueHandler($gate, $userRepo, $leagueRepo);

        $this->expectException(NoPermissionExpection::class);
        $handler->handle(new LeaveLeagueCommand(1, 2));

        $gate->shouldHaveReceived('denies')->with('leaveLeague', [$league, $user])->once();
    }

    private function makeUserRepoMock($user)
    {
        return m::spy(UserRepository::class)
            ->shouldReceive('findOrFail')
            ->andReturn($user)
            ->getMock();
    }

    private function makeUserMock()
    {
        return m::spy(User::class);
    }
    
    private function makeLeagueRepoMock($league)
    {
        return m::spy(LeagueRepository::class)
            ->shouldReceive('findOrFail')->andReturn($league)
            ->getMock();
    }

    private function makeLeagueMock()
    {
        return m::spy(League::class);
    }
}
