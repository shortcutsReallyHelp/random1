<?php

namespace Tests\Unit;

use App\Game\Entities\Division;
use App\Game\Entities\Team;
use App\Game\GameRunner;
use App\Game\WinnerTeamsDetector;
use Mockery\MockInterface;
use Tests\TestCase;

class GameRunnerTest extends TestCase
{
    public function testTeam1AWins()
    {
        $firstDivision = new Division(
            'First', [
                new Team('1A'),
                new Team('1B'),
                new Team('1C'),
                new Team('1D'),
                new Team('1E'),
                new Team('1F'),
                new Team('1G'),
                new Team('1H'),
            ]
        );
        $secondDivision = new Division(
            'First', [
                new Team('2A'),
                new Team('2B'),
                new Team('2C'),
                new Team('2D'),
                new Team('2E'),
                new Team('2F'),
                new Team('2G'),
                new Team('2H'),
            ]
        );

        $this->mock(WinnerTeamsDetector::class, function (MockInterface $mock) {
            //amongst divisions
            $mock->shouldReceive('detectWinnerTeams')->andReturn([
                new Team('1A'),
                new Team('1B'),
                new Team('1C'),
                new Team('1D'),
            ]);
            $mock->shouldReceive('detectWinnerTeams')->andReturn([
                new Team('2A'),
                new Team('2B'),
                new Team('2C'),
                new Team('2D'),
            ]);

            //playOff
            $mock->shouldReceive('detectWinnerTeams')->andReturn([
                new Team('1A'),
                new Team('1B'),
                new Team('2A'),
                new Team('2B'),
            ]);

            //semiFinal
            $mock->shouldReceive('detectWinnerTeams')->andReturn([
                new Team('1A'),
                new Team('2A'),
            ]);

            //final
            $mock->shouldReceive('detectWinnerTeams')->andReturn([
                new Team('1A')
            ]);
        });

        /**
         * @var GameRunner $gameRunner
         */
        $gameRunner = $this->app->make(GameRunner::class);
        $winnerTeam = $gameRunner->run('2021 game', $firstDivision, $secondDivision);

        $this->assertEquals('1A', $winnerTeam->getName());
    }
}
