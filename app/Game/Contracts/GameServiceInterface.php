<?php


namespace App\Game\Contracts;


use App\Game\Contracts\Entities\MatchInterface;

interface GameServiceInterface
{
    /**
     * @param string $gameKey
     * @param int $gameStepType
     * @param MatchInterface[] $matches
     */
    public function saveMatchResults(string $gameKey, int $gameStepType, array $matches): void;
}
