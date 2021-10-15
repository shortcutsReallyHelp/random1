<?php

namespace Tests\Unit;

use App\Game\Entities\Team;
use App\Game\WinnerTeamsDetector;
use PHPUnit\Framework\TestCase;

class WinnerTeamsDetectorTest extends TestCase
{
    public function testDetectWinnerFromTwo()
    {
        $winnerTeamsDetector = new WinnerTeamsDetector();
        $winnerTeams = $winnerTeamsDetector->detectWinnerTeams(1, [(new Team('A'))->incrementScore(2), (new Team('B'))->incrementScore(5)]);

        $this->assertEquals('B', $winnerTeams[0]->getName());
    }
}
