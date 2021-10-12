<?php

namespace App\Game\Contracts;

use App\Game\Contracts\Entities\TeamInterface;

interface WinnerTeamsDetectorInterface
{
    /**
     * @param int $topFirst
     * @param array $teams
     * @return TeamInterface[]
     */
    public function detectWinnerTeams(int $topFirst, array $teams): array;
}
