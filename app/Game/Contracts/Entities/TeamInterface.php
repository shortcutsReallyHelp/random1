<?php

namespace App\Game\Contracts\Entities;

interface TeamInterface
{
    public function getName(): string;

    public function getScore(): int;
    public function incrementScore(int $to): self;

    public function resetScore(): self;
}
