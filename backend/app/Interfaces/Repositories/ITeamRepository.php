<?php

namespace App\Interfaces\Repositories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

interface ITeamRepository
{
    public function getAll(): Collection;

    public function getByConditions(array $condition): ?Team;

    public function save(array $properties): ?Team;

    public function update(int $id, array $properties): int;
}
