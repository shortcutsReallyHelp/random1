<?php

namespace App\Game\Contracts;

use App\Game\Contracts\Entities\DivisionInterface;
use App\Game\Contracts\Entities\MatchInterface;

interface MatchDistributorInterface
{
    /**
     * @param DivisionInterface $division
     * @return MatchInterface[]
     */
    public function distributeTeamsAmongstOneDivision(DivisionInterface $division): array;

    /**
     * @param DivisionInterface $firstDivision
     * @param DivisionInterface $secondDivision
     * @return MatchInterface[]
     */
    public function distributeTeamsAgainstDivisions(DivisionInterface $firstDivision, DivisionInterface $secondDivision): array;
}
