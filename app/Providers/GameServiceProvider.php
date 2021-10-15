<?php


namespace App\Providers;


use App\Game\Contracts\GameRunnerInterface;
use App\Game\Contracts\GameServiceInterface;
use App\Game\Contracts\MatchDistributorInterface;
use App\Game\Contracts\MatchRunnerInterface;
use App\Game\Contracts\WinnerTeamsDetectorInterface;
use App\Game\GameRunner;
use App\Game\MatchDistributor;
use App\Game\MatchRunner;
use App\Game\WinnerTeamsDetector;
use App\Services\Game\GameService;
use Illuminate\Support\ServiceProvider;

class GameServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(MatchRunnerInterface::class, MatchRunner::class);
        $this->app->bind(GameRunnerInterface::class, GameRunner::class);
        $this->app->bind(MatchDistributorInterface::class, MatchDistributor::class);
        $this->app->bind(WinnerTeamsDetectorInterface::class, WinnerTeamsDetector::class);

        $this->app->bind(GameServiceInterface::class, GameService::class);
    }
}
