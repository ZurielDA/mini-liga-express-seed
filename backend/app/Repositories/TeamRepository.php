<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ITeamRepository;
use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

class TeamRepository implements ITeamRepository
{
    public function getAll(): Collection
    {
        return Team::with(['homeSoportMatches', 'awayMatches'])->get();
    }

    public function getByConditions(array $condition): ?Team
    {
        return Team::where($condition)->first();
    }

    public function save(array $properties): Team
    {
        return Team::create($properties)->refresh();
    }

    public function update(int $id, array $properties): int
    {
        return Team::whereId($id)->update($properties);
    }
}
