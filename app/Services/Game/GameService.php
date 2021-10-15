<?php


namespace App\Services\Game;


use App\Game\Contracts\Entities\MatchInterface;
use App\Game\Contracts\GameServiceInterface;

class GameService implements GameServiceInterface
{

    public function saveMatchResults(string $gameKey, int $gameStepType, array $matches): void
    {
        // TODO: Implement saveMatchResults() method.
    }
}
