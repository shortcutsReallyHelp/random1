<?php

namespace App\Game\Contracts;

use App\Game\Contracts\Entities\DivisionInterface;
use App\Game\Contracts\Entities\MatchInterface;
use App\Game\Contracts\Entities\TeamInterface;

interface MatchDistributorInterface
{
    /**
     * @param DivisionInterface $division
     * @return MatchInterface[]
     */
    public function distributeTeamsAmongstOneDivision(DivisionInterface $division): array;

    /**
     * @param array $firstDivisionTeams
     * @param array $secondDivisionTeams
     * @return MatchInterface[]
     */
    public function distributeTeamsAgainstDivisionsInPlayOff(array $firstDivisionTeams, array $secondDivisionTeams): array;

    /**
     * @param array $teams
     * @return MatchInterface[]
     */
    public function distributeTeamsInSemiFinal(array $teams): array;

    /**
     * @param TeamInterface $firstTeam
     * @param TeamInterface $secondTeam
     * @return MatchInterface
     */
    public function distributeTeamsInFinal(TeamInterface $firstTeam, TeamInterface $secondTeam): MatchInterface;
}
