<?php

namespace App\Service\Bus\Handler\League;

use App\Domain\League\LeagueRepository;
use App\Service\Acl\User\UserRepository;
use Illuminate\Contracts\Auth\Access\Gate;
use App\Service\Bus\Command\League\LeaveLeagueCommand;
use App\Exceptions\NoPermissionExpection;

class LeaveLeagueHandler
{
    public function __construct(Gate $gate, UserRepository $userRepo, LeagueRepository $leagueRepo)
    {
        $this->gate = $gate;
        $this->userRepo = $userRepo;
        $this->leagueRepo = $leagueRepo;
    }

    public function handle(LeaveLeagueCommand $command)
    {
        $user = $this->userRepo->findOrFail($command->userId);
        $league = $this->leagueRepo->findOrFail($command->leagueId);

        $this->checkPermission($user, $league);

        $user->leave($league);
    }

    private function checkPermission($user, $league)
    {
        if ($this->gate->denies('leaveLeague', [$league, $user])) {
            throw new NoPermissionExpection('Keine Berechtigung um Benutzter aus Gruppe zu entfernen.');
        }
    }
}
