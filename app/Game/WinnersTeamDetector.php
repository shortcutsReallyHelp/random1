<?php

namespace App\Game;

use App\Game\Contracts\Entities\TeamInterface;
use App\Game\Contracts\WinnerTeamsDetectorInterface;

class WinnersTeamDetector implements WinnerTeamsDetectorInterface
{
    /**
     * @param int $topFirst
     * @param TeamInterface[] $teams
     * @return array
     */
    public function detectWinnerTeams(int $topFirst, array $teams): array
    {
        usort($teams, fn(TeamInterface $firstTeam, TeamInterface $secondTeam) => $firstTeam->getScore() > $secondTeam->getScore());

        return array_chunk($teams, $topFirst)[0];
    }
}
