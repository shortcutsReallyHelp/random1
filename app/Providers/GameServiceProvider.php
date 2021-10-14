<?php


namespace App\Providers;


use App\Game\Contracts\GameRunnerInterface;
use App\Game\Contracts\GameServiceInterface;
use App\Game\Contracts\MatchDistributorInterface;
use App\Game\Contracts\WinnerTeamsDetectorInterface;
use App\Game\GameRunner;
use App\Game\MatchDistributor;
use App\Game\WinnersTeamDetector;
use App\Services\Game\GameService;
use Illuminate\Support\ServiceProvider;

class GameServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->instance(GameRunnerInterface::class, GameRunner::class);
        $this->app->instance(MatchDistributorInterface::class, MatchDistributor::class);
        $this->app->instance(WinnerTeamsDetectorInterface::class, WinnersTeamDetector::class);

        $this->app->instance(GameServiceInterface::class, GameService::class);
    }
}
