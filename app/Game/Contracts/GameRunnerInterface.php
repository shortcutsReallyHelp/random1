<?php

namespace App\Game\Contracts;

use App\Game\Contracts\Entities\DivisionInterface;
use App\Game\Contracts\Entities\TeamInterface;

interface GameRunnerInterface
{
    public function run(string $gameKey, DivisionInterface $firstDivision, DivisionInterface $secondDivision): TeamInterface;
}
