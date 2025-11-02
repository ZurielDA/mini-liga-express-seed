<?php

namespace App\Providers;

use App\Interfaces\Repositories\ISportMatchRepository;
use App\Interfaces\Repositories\ITeamRepository;
use App\Interfaces\Services\ISportMatchService;
use App\Interfaces\Services\IStandingsService;
use App\Interfaces\Services\ITeamService;
use App\Repositories\SportMatchRepository;
use App\Repositories\TeamRepository;
use App\Services\SportMatchService;
use App\Services\StandingsService;
use App\Services\TeamService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Repositories
        $this->app->bind(ITeamRepository::class, TeamRepository::class);
        $this->app->bind(ISportMatchRepository::class, SportMatchRepository::class);

        // Service
        $this->app->bind(ITeamService::class, TeamService::class);
        $this->app->bind(ISportMatchService::class, SportMatchService::class);
        $this->app->bind(IStandingsService::class, StandingsService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
