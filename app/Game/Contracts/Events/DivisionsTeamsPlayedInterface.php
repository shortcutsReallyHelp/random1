<?php

namespace App\Game\Contracts\Events;

use App\Game\Contracts\Entities\DivisionInterface;

interface DivisionsTeamsPlayedInterface extends MatchesPlayedInterface
{
    /**
     * @return DivisionInterface
     */
    public function getDivision(): DivisionInterface;
}
