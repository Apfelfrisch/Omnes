<?php

namespace App\Service\Bus\Handler\Activity;

use App\Domain\Adress\Adress;
use App\Domain\Contact\Contact;
use App\Domain\Activity\Activity;
use App\Domain\League\LeagueRepository;
use Illuminate\Contracts\Auth\Access\Gate;
use App\Domain\Activity\ActivityRepository;
use App\Service\Bus\Command\Activity\PublishActivityCommand;
use App\Exceptions\NoPermissionExpection;

class PublishActivityHandler
{
    private $gate;
    private $activityRepo;
    
    public function __construct(Gate $gate, ActivityRepository $activityRepo, LeagueRepository $leagueRepo)
    {
        $this->gate = $gate;
        $this->activityRepo = $activityRepo;
        $this->leagueRepo = $leagueRepo;
    }

    public function handle(PublishActivityCommand $command)
    {
        $activity = $this->activityRepo->create($command->activity);
        $activity->addLeague($this->leagueRepo->findOrFail($command->activity['league_id']));
        
        // Wir können erst hier die berechtigung prüfen
        // weil Gate die league-Assaciation auf activity benötigt
        $this->checkPermssion($activity);

        $activity->setAdress($command->adress);
        $activity->setContact($command->contact);

        return $this->activityRepo->persist($activity);
    }

    private function checkPermssion($activity)
    {
        if ($this->gate->denies('save', $activity)) {
            throw new NoPermissionExpection('Keine Berechtigung um Nutzerdaten zu verändern.');
        }
    }
}
