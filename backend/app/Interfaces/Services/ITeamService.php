<?php

namespace App\Interfaces\Services;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

interface ITeamService
{
    public function getAll(): Collection;

    public function getByConditions(array $conditions): ?Team;

    public function save(array $properties): ?Team;

    public function update(int $id, array $properties): ?Team;

    public function addGoals(int $home_team_id, int $home_score, int $away_team_id, int $away_score): void;
}
