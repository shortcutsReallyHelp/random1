<?php

namespace App\Game\Contracts;

use App\Game\Contracts\Entities\MatchInterface;

interface MatchRunnerInterface
{
    public function run(MatchInterface $match): void;
}
