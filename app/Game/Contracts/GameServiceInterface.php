<?php


namespace App\Game\Contracts;


use App\Game\Contracts\Entities\MatchInterface;

interface GameServiceInterface
{
    /**
     * @param MatchInterface[] $matches
     */
    public function saveMatchResults(array $matches): void;
}
