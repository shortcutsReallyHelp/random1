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
use App\Game\Entities\Match;

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

    public function run(string $gameKey, DivisionInterface $firstDivision, DivisionInterface $secondDivision): TeamInterface
    {
        $firstDivisionWinners = $this->runFirstStepForDivision($gameKey, $firstDivision);
        $secondDivisionWinners = $this->runFirstStepForDivision($gameKey, $secondDivision);

        $playOffWinners = $this->runPlayOff($gameKey, $firstDivisionWinners, $secondDivisionWinners);
        $semiFinalWinners = $this->runSemiFinal($gameKey, $playOffWinners);
        return $this->runFinal($gameKey, ...$semiFinalWinners);
    }

    /**
     * @param TeamInterface[] $firstDivisionWinners
     * @param TeamInterface[] $secondDivisionWinners
     * @return TeamInterface[]
     */
    private function runPlayOff(string $gameKey, array $firstDivisionWinners, array $secondDivisionWinners): array
    {
        array_walk($firstDivisionWinners, fn(TeamInterface $team) => $team->resetScore());
        array_walk($secondDivisionWinners, fn(TeamInterface $team) => $team->resetScore());

        $matches = $this->matchDistributor->distributeTeamsAgainstDivisionsInPlayOff($firstDivisionWinners, $secondDivisionWinners);
        $this->runMatches($matches);

        $this->gameService->saveMatchResults($gameKey, Match::STEP_TYPE_PLAY_OFF, $matches);
        return $this->winnerTeamsDetector->detectWinnerTeams(self::PLAY_OFF_TOP, [
            ...$firstDivisionWinners,
            ...$secondDivisionWinners,
        ]);
    }

    /**
     * @param string $gameKey
     * @param TeamInterface[] $teams
     * @return TeamInterface[] $teams
     */
    private function runSemiFinal(string $gameKey, array $teams): array
    {
        array_walk($teams, fn(TeamInterface $team) => $team->resetScore());

        $matches = $this->matchDistributor->distributeTeamsInSemiFinal($teams);
        $this->runMatches($matches);

        $this->gameService->saveMatchResults($gameKey, Match::STEP_TYPE_SEMIFINAL, $matches);
        return $this->winnerTeamsDetector->detectWinnerTeams(self::SEMIFINAL_TOP, $teams);
    }

    /**
     * @param string $gameKey
     * @param DivisionInterface $division
     * @return TeamInterface[]
     */
    private function runFirstStepForDivision(string $gameKey, DivisionInterface $division): array
    {
        $divisionMatches = $this->distributeTeams($division);
        $this->runMatches($divisionMatches);

        $this->gameService->saveMatchResults($gameKey, Match::STEP_TYPE_DIVISION, $divisionMatches);
        return $this->winnerTeamsDetector->detectWinnerTeams(self::FIRST_TOP, $division->getTeams());
    }
    /**
     * @param string $gameKey
     * @param TeamInterface $firstTeam
     * @param TeamInterface $secondTeam
     * @return TeamInterface
     */
    private function runFinal(string $gameKey, TeamInterface $firstTeam, TeamInterface $secondTeam): TeamInterface
    {
        $match = $this->matchDistributor->distributeTeamsInFinal($firstTeam, $secondTeam);

        $this->runMatches([$match]);

        $this->gameService->saveMatchResults($gameKey, Match::STEP_TYPE_FINAL, [$match]);
        return $this->winnerTeamsDetector->detectWinnerTeams(self::FINAL, [$firstTeam, $secondTeam])[0];
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
