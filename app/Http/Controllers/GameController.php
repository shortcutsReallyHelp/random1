<?php

namespace App\Http\Controllers;

use App\Game\Contracts\GameRunnerInterface;
use App\Http\Resources\MatchResource;
use App\Http\Resources\TeamEntityResource;
use App\Models\Match;
use App\Services\Game\GameGeneratorService;
use Illuminate\Support\Str;

class GameController extends Controller
{
    public function index()
    {
        return MatchResource::collection(Match::query()
            ->with('leftTeam', 'rightTeam')
            ->paginate(request()->input('per_page')));
    }

    public function store(GameGeneratorService $gameGeneratorService, GameRunnerInterface $gameRunner)
    {
        $game = $gameGeneratorService->generate();

        $winner = $gameRunner->run(Str::random(), $game->getFirstDivision(), $game->getSecondDivision());

        return new TeamEntityResource($winner);
    }
}
