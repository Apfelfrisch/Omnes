<?php

namespace Test\Unit\ServiceCommand\Activity;

use TestCase;
use Mockery as m;
use Faker\Factory as Faker;
use App\Domain\Adress\Adress;
use App\Domain\League\League;
use App\Domain\Contact\Contact;
use App\Domain\Activity\Activity;
use App\Domain\League\LeagueRepository;
use App\Exceptions\NoPermissionExpection;
use App\Domain\Activity\ActivityRepository;
use App\Service\Bus\Command\Activity\PublishActivityCommand;
use App\Service\Bus\Handler\Activity\PublishActivityHandler;

class PublishActivityTest extends TestCase
{
    private $cache = [];

    /** @test */
    public function it_publish_a_new_activity()
    {
        $league_id = 1;
        $adress = $this->getAdress();
        $contact = $this->getContact();
        $description = Faker::create()->text;
        
        $handler = new PublishActivityHandler(
            $this->makeGateWichAllowsPermission(), 
            $activityRepo = $this->getActivityRepoMock($activity = $this->getActivity()), 
            $this->leagueRepoMock()
        );
        $handler->handle(new PublishActivityCommand(compact('contact', 'adress', 'description', 'league_id')));

        $activity->shouldHaveReceived('addLeague')->with($this->getLeague())->once();
        $activity->shouldHaveReceived('setAdress')->with($this->getAdress())->once();
        $activity->shouldHaveReceived('setContact')->with($this->getContact())->once();
        $activityRepo->shouldHaveReceived('persist')->once();
    }

    /** @test */
    public function it_disallows_publish_a_new_activity()
    {
        $league_id = 1;
        $adress = $this->getAdress();
        $contact = $this->getContact();
        $description = Faker::create()->text;
        
        $handler = new PublishActivityHandler(
            $this->makeGateWichDeniesPermission(), 
            $activityRepo = $this->getActivityRepoMock($activity = $this->getActivity()), 
            $this->leagueRepoMock()
        );

        $this->expectException(NoPermissionExpection::class);
        $handler->handle(new PublishActivityCommand(compact('contact', 'adress', 'description', 'league_id')));

        $activity->shouldHaveReceived('addLeague')->with($this->getLeague())->once();
        $activity->shouldHaveReceived('setAdress')->never();
        $activity->shouldHaveReceived('setContact')->never();
        $activityRepo->shouldHaveReceived('persist')->never();
    }

    private function getActivityRepoMock()
    {
        return m::spy(ActivityRepository::class)
            ->shouldReceive('create')->andReturn($this->getActivity())
            ->getMock();
    }

    private function leagueRepoMock()
    {
        return m::mock(LeagueRepository::class)
            ->shouldReceive('findOrFail')->with(1)->andReturn($this->getLeague())
            ->getMock();
    }

    private function getActivity()
    {
        if (!isset($this->cache['activity'])) {
            $this->cache['activity'] = m::spy(Activity::class);
        }
        return $this->cache['activity'];
    }

    private function getLeague()
    {
        if (!isset($this->cache['league'])) {
            $this->cache['league'] = factory(League::class)->make(['adress_id' => null, 'contact_id' => null]);
        }
        return $this->cache['league'];
    }

    private function getContact()
    {
        if (!isset($this->cache['contact'])) {
            $this->cache['contact'] = factory(Contact::class)->make()->toArray();
        }
        return $this->cache['contact'];
    }
    
    private function getAdress()
    {
        if (!isset($this->cache['adress'])) {
            $this->cache['adress'] = factory(Adress::class)->make()->toArray();
        }
        return $this->cache['adress'];
    }
}
