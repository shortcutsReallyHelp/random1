<?php

namespace App\Game\Contracts;

use App\Game\Contracts\Entities\DivisionInterface;

interface GameRunnerInterface
{
    public function run(DivisionInterface $firstDivision, DivisionInterface $secondDivision): void;
}
