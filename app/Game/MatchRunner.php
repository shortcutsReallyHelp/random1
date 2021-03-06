<?php

namespace App\Game;

use App\Game\Contracts\Entities\MatchInterface;
use App\Game\Contracts\MatchRunnerInterface;

class MatchRunner implements MatchRunnerInterface
{
    public function run(MatchInterface $match): void
    {
        $match->incrementLeftTeamScore(rand(0,6));
        $match->incrementRightTeamScore(rand(0,6));

        $match->getRightTeam()->incrementScore($match->getRightTeamScore());
        $match->getLeftTeam()->incrementScore($match->getLeftTeamScore());

        if ($match->getLeftTeamScore() == $match->getRightTeamScore()) {
            $this->run($match);
        }
    }
}
