<?php

namespace App\Game\Contracts\Entities;

interface DivisionInterface
{
    public function getName(): string;

    /**
     * @return TeamInterface[]
     */
    public function getTeams(): array;
}
