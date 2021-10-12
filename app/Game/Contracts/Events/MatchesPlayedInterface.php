<?php

namespace App\Game\Contracts\Events;

use App\Game\Contracts\Entities\MatchInterface;
use App\Game\Contracts\Entities\TeamInterface;

interface MatchesPlayedInterface
{
    /**
     * @return MatchInterface[]
     */
    public function getMatches(): array;

    /**
     * @return TeamInterface[]
     */
    public function getWinnersOrderedByScore(): array;
}
