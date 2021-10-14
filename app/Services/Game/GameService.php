<?php


namespace App\Services\Game;


use App\Game\Contracts\Entities\MatchInterface;
use App\Game\Contracts\GameServiceInterface;

class GameService implements GameServiceInterface
{
    /**
     * @param MatchInterface[] $matches
     */
    public function saveMatchResults(array $matches): void
    {
        // TODO: Implement saveMatchResults() method.
    }
}
