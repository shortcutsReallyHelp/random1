<?php


namespace App\Services\Game;


use App\Game\Contracts\Entities\MatchInterface;
use App\Game\Contracts\GameServiceInterface;
use App\Models\Match;
use App\Models\Team;
use Illuminate\Support\Collection;

class GameService implements GameServiceInterface
{
    /**
     * @param string $gameKey
     * @param int $gameStepType
     * @param MatchInterface[] $matches
     */
    public function saveMatchResults(string $gameKey, int $gameStepType, array $matches): void
    {
        $insertingMatches = collect();
        $teamNames = collect($matches)
            ->map(function (MatchInterface $match) {
                return [$match->getLeftTeam()->getName(), $match->getRightTeam()->getName()];
            })
            ->flatten(1);

        $teams = Team::query()->whereIn('name', $teamNames)->pluck('id', 'name');

        foreach ($matches as $match) {
            $leftTeamId = $this->getOrInsertTeamByName($teams, $match->getLeftTeam()->getName());
            $rightTeamId = $this->getOrInsertTeamByName($teams, $match->getRightTeam()->getName());

            $insertingMatches->add([
                'left_team_id' => $leftTeamId,
                'right_team_id' => $rightTeamId,
                'left_team_score' => $match->getLeftTeam()->getScore(),
                'right_team_score' => $match->getRightTeam()->getScore(),
                'step_type' => $gameStepType,
                'game_key' => $gameKey,
            ]);
        }

        Match::query()->insert($insertingMatches->toArray());
    }

    private function getOrInsertTeamByName(Collection $teams, string $name): int
    {
        if (isset($teams[$name])) {
            return $teams[$name];
        }
        $team = Team::query()->create(['name' => $name]);
        $teams[$team->name] = $team->id;
        return $team->id;
    }
}
