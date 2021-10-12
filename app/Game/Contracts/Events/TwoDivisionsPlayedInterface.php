<?php

namespace App\Game\Contracts\Events;

use App\Game\Contracts\Entities\DivisionInterface;

interface TwoDivisionsPlayedInterface extends MatchesPlayedInterface
{
    /**
     * @return DivisionInterface
     */
    public function getFirstDivision(): DivisionInterface;

    /**
     * @return DivisionInterface
     */
    public function getSecondDivision(): DivisionInterface;
}
