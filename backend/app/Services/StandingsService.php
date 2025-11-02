<?php

namespace App\Services;

use App\Enums\POINTS;
use App\Interfaces\Services\IStandingsService;
use App\Interfaces\Services\ITeamService;
use App\Models\SportMatch;
use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

class StandingsService implements IStandingsService
{
    protected $teamService;

    public function __construct(ITeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    public function get(): array
    {
        $standing = collect([]);

        $teams = $this->teamService->getAll()->map(function (Team $team, int $keyteam) {
            $team->setRelation(
                'homeSoportMatches',
                $team->homeSoportMatches->whereNotNull('home_score')->whereNotNull('away_score')
            );

            $team->setRelation(
                'awayMatches',
                $team->awayMatches->whereNotNull('home_score')->whereNotNull('away_score')
            );

            return $team;
        })
            ->filter(function (Team $team, int $key) {
                return $team->homeSoportMatches->isNotEmpty() || $team->awayMatches->isNotEmpty();
            })
            ->each(function (Team $team, int $key) use (&$standing) {
                $standing->add([
                    'team' => $team->name,
                    'played' => $team->played,
                    'point' => $this->calculatePoints($team->homeSoportMatches, $team->awayMatches),
                    'goals_for' => $team->goals_for,
                    'goals_against' => $team->goals_against,
                    'goal_diff' => $team->goals_for - $team->goals_against,
                ]);
            });

        return $standing->sortByDesc('points')->sortByDesc('goal_diff')->sortByDesc('goals_for')->values()->toArray();
    }

    public function calculatePoints(Collection $homeSoportMatches, Collection $awayMatches): int
    {
        $point = 0;

        $homeSoportMatches->each(function (SportMatch $sportMatch) use (&$point) {
            if ($sportMatch->home_score > $sportMatch->away_score) {
                $point += POINTS::WON->value;
            } elseif ($sportMatch->home_score > $sportMatch->away_score) {
                $point += POINTS::DRAW->value;
            } elseif ($sportMatch->home_score < $sportMatch->away_score) {
                $point += POINTS::LOST->value;
            }
        });

        $awayMatches->each(function (SportMatch $sportMatch) use (&$point) {
            if ($sportMatch->away_score > $sportMatch->home_score) {
                $point += POINTS::WON->value;
            } elseif ($sportMatch->away_score > $sportMatch->home_score) {
                $point += POINTS::DRAW->value;
            } elseif ($sportMatch->away_score < $sportMatch->home_score) {
                $point += POINTS::LOST->value;
            }
        });

        return $point;
    }
}
