<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ISportMatchRepository;
use App\Models\SportMatch;
use Illuminate\Database\Eloquent\Collection;

class SportMatchRepository implements ISportMatchRepository
{
    public function getAll(): Collection
    {
        return SportMatch::with(['homeTema', 'awayTeam'])->get();
    }

    public function getByConditions(array $condition): ?SportMatch
    {
        return SportMatch::where($condition)->first();
    }

    public function save(array $properties): SportMatch
    {
        return SportMatch::create($properties);
    }

    public function update(int $id, array $properties): int
    {
        return SportMatch::whereId($id)->update($properties);
    }
}
