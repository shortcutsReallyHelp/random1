<?php

namespace App\Game;

use App\Game\Contracts\Entities\DivisionInterface;
use App\Game\Contracts\Entities\MatchInterface;
use App\Game\Contracts\Entities\TeamInterface;
use App\Game\Contracts\GameRunnerInterface;
use App\Game\Contracts\GameServiceInterface;
use App\Game\Contracts\MatchDistributorInterface;
use App\Game\Contracts\MatchRunnerInterface;
use App\Game\Contracts\WinnerTeamsDetectorInterface;

class GameRunner implements GameRunnerInterface
{
    private const FIRST_TOP = 4;
    private const PLAY_OFF_TOP = 4;
    private const SEMIFINAL_TOP = 2;
    private const FINAL = 1;

    private MatchDistributorInterface $matchDistributor;
    private MatchRunnerInterface $matchRunner;
    private WinnerTeamsDetectorInterface $winnerTeamsDetector;
    private GameServiceInterface $gameService;

    /**
     * GameRunner constructor.
     * @param MatchDistributorInterface $matchDistributor
     * @param MatchRunnerInterface $matchRunner
     * @param WinnerTeamsDetectorInterface $winnerTeamsDetector
     * @param GameServiceInterface $gameService
     */
    public function __construct(
        MatchDistributorInterface $matchDistributor,
        MatchRunnerInterface $matchRunner,
        WinnerTeamsDetectorInterface $winnerTeamsDetector,
        GameServiceInterface $gameService
    ) {
        $this->matchDistributor = $matchDistributor;
        $this->matchRunner = $matchRunner;
        $this->winnerTeamsDetector = $winnerTeamsDetector;
        $this->gameService = $gameService;
    }

    public function run(DivisionInterface $firstDivision, DivisionInterface $secondDivision): TeamInterface
    {
        $firstDivisionWinners = $this->runFirstStepForDivision($firstDivision);
        $secondDivisionWinners = $this->runFirstStepForDivision($secondDivision);

        $playOffWinners = $this->runPlayOff($firstDivisionWinners, $secondDivisionWinners);
        $semiFinalWinners = $this->runSemiFinal($playOffWinners);
        return $this->runFinal(...$semiFinalWinners);
    }

    /**
     * @param TeamInterface[] $firstDivisionWinners
     * @param TeamInterface[] $secondDivisionWinners
     * @return TeamInterface[]
     */
    private function runPlayOff(array $firstDivisionWinners, array $secondDivisionWinners): array
    {
        array_walk($firstDivisionWinners, fn(TeamInterface $team) => $team->resetScore());
        array_walk($secondDivisionWinners, fn(TeamInterface $team) => $team->resetScore());

        $matches = $this->matchDistributor->distributeTeamsAgainstDivisionsInPlayOff($firstDivisionWinners, $secondDivisionWinners);
        $this->runMatches($matches);
        return $this->winnerTeamsDetector->detectWinnerTeams(self::PLAY_OFF_TOP, $matches);
    }

    /**
     * @param TeamInterface[] $teams
     * @return TeamInterface[] $teams
     */
    private function runSemiFinal(array $teams): array
    {
        array_walk($teams, fn(TeamInterface $team) => $team->resetScore());

        $matches = $this->matchDistributor->distributeTeamsInSemiFinal($teams);
        $this->runMatches($matches);
        return $this->winnerTeamsDetector->detectWinnerTeams(self::SEMIFINAL_TOP, $matches);
    }

    /**
     * @param DivisionInterface $division
     * @return TeamInterface[]
     */
    private function runFirstStepForDivision(DivisionInterface $division): array
    {
        $divisionMatches = $this->distributeTeams($division);
        $this->runMatches($divisionMatches);
        return $this->winnerTeamsDetector->detectWinnerTeams(self::FIRST_TOP, $divisionMatches);
    }
    /**
     * @param TeamInterface $firstTeam
     * @param TeamInterface $secondTeam
     * @return TeamInterface
     */
    private function runFinal(TeamInterface $firstTeam, TeamInterface $secondTeam): TeamInterface
    {
        $match = $this->matchDistributor->distributeTeamsInFinal($firstTeam, $secondTeam);

        $this->runMatches([$match]);
        return $this->winnerTeamsDetector->detectWinnerTeams(self::FINAL, [$match])[0];
    }

    /**
     * @param DivisionInterface $division
     * @return MatchInterface[]
     */
    private function distributeTeams(DivisionInterface $division): array
    {
        return $this->matchDistributor->distributeTeamsAmongstOneDivision($division);
    }

    /**
     * @param MatchInterface[] $matches
     * @return void
     */
    private function runMatches(array $matches): void
    {
        array_walk($matches, function (MatchInterface $match) {
            $this->matchRunner->run($match);
        });
    }
}
