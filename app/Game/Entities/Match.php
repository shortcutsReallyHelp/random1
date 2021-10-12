<?php

namespace App\Game\Entities;

use App\Game\Contracts\Entities\MatchInterface;
use App\Game\Contracts\Entities\TeamInterface;

class Match implements MatchInterface
{
    private int $leftTeamScore;
    private int $rightTeamScore;
    private TeamInterface $leftTeam;
    private TeamInterface $rightTeam;

    /**
     * @param TeamInterface $leftTeam
     * @param TeamInterface $rightTeam
     */
    public function __construct(TeamInterface $leftTeam, TeamInterface $rightTeam)
    {
        $this->leftTeam = $leftTeam;
        $this->rightTeam = $rightTeam;
        $this->leftTeamScore = 0;
        $this->rightTeamScore = 0;
    }


    public function incrementLeftTeamScore(int $to = 1): MatchInterface
    {
        $this->leftTeamScore += $to;
        return $this;
    }

    public function incrementRightTeamScore(int $to = 1): MatchInterface
    {
        $this->rightTeamScore += $to;
        return $this;
    }

    /**
     * @return int
     */
    public function getLeftTeamScore(): int
    {
        return $this->leftTeamScore;
    }

    /**
     * @return int
     */
    public function getRightTeamScore(): int
    {
        return $this->rightTeamScore;
    }

    /**
     * @return TeamInterface
     */
    public function getLeftTeam(): TeamInterface
    {
        return $this->leftTeam;
    }

    /**
     * @return TeamInterface
     */
    public function getRightTeam(): TeamInterface
    {
        return $this->rightTeam;
    }


}
