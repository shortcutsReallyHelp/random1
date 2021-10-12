<?php

namespace App\Game\Contracts\Entities;

interface MatchInterface
{
    public function getLeftTeam(): TeamInterface;
    public function getRightTeam(): TeamInterface;

    public function incrementLeftTeamScore(int $to = 1): self;
    public function incrementRightTeamScore(int $to = 1): self;

    public function getLeftTeamScore(): int;
    public function getRightTeamScore(): int;
}
