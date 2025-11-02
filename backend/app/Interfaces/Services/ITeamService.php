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
}
