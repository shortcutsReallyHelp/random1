<?php

namespace App\Game\Contracts\Entities;

interface MatchInterface
{
    public const STEP_TYPE_DIVISION = 1;
    public const STEP_TYPE_PLAY_OFF = 2;
    public const STEP_TYPE_SEMIFINAL = 3;
    public const STEP_TYPE_FINAL = 4;

    public function getLeftTeam(): TeamInterface;
    public function getRightTeam(): TeamInterface;

    public function incrementLeftTeamScore(int $to = 1): self;
    public function incrementRightTeamScore(int $to = 1): self;

    public function getLeftTeamScore(): int;
    public function getRightTeamScore(): int;
}
