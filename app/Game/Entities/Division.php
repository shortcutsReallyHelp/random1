<?php

namespace App\Game\Entities;

use App\Game\Contracts\Entities\DivisionInterface;
use App\Game\Contracts\Entities\TeamInterface;

class Division implements DivisionInterface
{
    private string $name;

    /**
     * @var TeamInterface[]
     */
    private array $teams;

    /**
     * @param string $name
     * @param TeamInterface[] $teams
     */
    public function __construct(string $name, array $teams)
    {
        $this->name = $name;
        $this->teams = $teams;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return TeamInterface[]
     */
    public function getTeams(): array
    {
        return $this->teams;
    }
}
