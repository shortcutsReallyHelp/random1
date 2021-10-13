<?php

namespace App\Game;

use App\Game\Contracts\Entities\DivisionInterface;
use App\Game\Contracts\Entities\MatchInterface;
use App\Game\Contracts\Entities\TeamInterface;
use App\Game\Contracts\MatchDistributorInterface;
use App\Game\Entities\Match;

class MatchDistributor implements MatchDistributorInterface
{
    /**
     * @param DivisionInterface $division
     * @return MatchInterface[]
     */
    public function distributeTeamsAmongstOneDivision(DivisionInterface $division): array
    {
        $matches = [];
        foreach ($division->getTeams() as $team) {
            foreach ($division->getTeams() as $oppositeTeam) {
                if ($team->getName() == $oppositeTeam->getName()) {
                    continue;
                }
                $matches[] = new Match($team, $oppositeTeam);
            }
        }
        return $matches;
    }

    /**
     * @param TeamInterface[] $firstDivisionTeams
     * @param TeamInterface[] $secondDivisionTeams
     * @return MatchInterface[]
     */
    public function distributeTeamsAgainstDivisionsInPlayOff(array $firstDivisionTeams, array $secondDivisionTeams): array
    {
        usort($firstDivisionTeams, fn(TeamInterface $firstTeam, TeamInterface $secondTeam) => $firstTeam->getScore() < $secondTeam->getScore());
        usort($secondDivisionTeams, fn(TeamInterface $firstTeam, TeamInterface $secondTeam) => $firstTeam->getScore() > $secondTeam->getScore());

        $matches = [];

        while (count($firstDivisionTeams) && count($secondDivisionTeams)) {
            $matches[] = new Match(array_pop($firstDivisionTeams), array_pop($firstDivisionTeams));
        }

        return $matches;
    }


    /**
     * @param TeamInterface[] $teams
     * @return MatchInterface[]
     */
    public function distributeTeamsInSemiFinal(array $teams): array
    {
        $matches = [];
        $lastIndex = count($teams) - 1;

        for ($i = 0; $i < (count($teams) / 2); $i++) {
            $matches[] = new Match($teams[$i], $teams[$lastIndex - $i]);
        }

        return $matches;
    }

    /**
     * @param TeamInterface $firstTeam
     * @param TeamInterface $secondTeam
     * @return MatchInterface
     */
    public function distributeTeamsInFinal(TeamInterface $firstTeam, TeamInterface $secondTeam): MatchInterface
    {
        return new Match($firstTeam, $secondTeam);
    }

}
