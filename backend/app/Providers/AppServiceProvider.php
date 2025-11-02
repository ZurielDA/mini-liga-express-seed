<?php

namespace App\Providers;

use App\Interfaces\Repositories\ITeamRepository;
use App\Interfaces\Services\ITeamService;
use App\Repositories\TeamRepository;
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

        // Service
        $this->app->bind(ITeamService::class, TeamService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
