<?php

namespace App\Game\Entities;

use App\Game\Contracts\Entities\TeamInterface;

class Team implements TeamInterface
{
    private string $name;
    private int $score;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    public function incrementScore(int $to): TeamInterface
    {
        $this->score += $to;
        return $this;
    }

    public function resetScore(): TeamInterface
    {
        $this->score = 0;
        return $this;
    }
}
