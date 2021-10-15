<?php

namespace App\Services\Game;

use App\Game\Entities\Division;
use App\Game\Entities\Team;
use App\Services\Game\Entities\Game;
use Illuminate\Support\Str;

class GameGeneratorService
{
    public function generate(): Game
    {
        $firstDivisionTeams = [];
        $secondDivisionTeams = [];

        for ($i = 0; $i < 8; $i++) {
            $firstDivisionTeams[] = new Team(Str::random());
            $secondDivisionTeams[] = new Team(Str::random());
        }

        $firstDivision = new Division(Str::random(), $firstDivisionTeams);
        $secondDivision = new Division(Str::random(), $secondDivisionTeams);

        return new Game($firstDivision, $secondDivision);
    }
}
