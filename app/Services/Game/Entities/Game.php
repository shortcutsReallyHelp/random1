<?php

namespace App\Services\Game\Entities;

use App\Game\Entities\Division;

class Game
{
    private Division $firstDivision;
    private Division $secondDivision;

    /**
     * @param Division $firstDivision
     * @param Division $secondDivision
     */
    public function __construct(Division $firstDivision, Division $secondDivision)
    {
        $this->firstDivision = $firstDivision;
        $this->secondDivision = $secondDivision;
    }

    /**
     * @return Division
     */
    public function getFirstDivision(): Division
    {
        return $this->firstDivision;
    }

    /**
     * @return Division
     */
    public function getSecondDivision(): Division
    {
        return $this->secondDivision;
    }
}
