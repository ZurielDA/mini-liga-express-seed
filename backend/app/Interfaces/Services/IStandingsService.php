<?php

namespace App\Interfaces\Services;

use Illuminate\Database\Eloquent\Collection;

interface IStandingsService
{
    public function get(): array;

    public function calculatePoints(Collection $homeSoportMatches, Collection $awayMatches): int;
}
