<?php

namespace App\Interfaces\Repositories;

use App\Models\SportMatch;
use Illuminate\Database\Eloquent\Collection;

interface ISportMatchRepository
{
    public function getAll(): Collection;

    public function getByConditions(array $condition): ?SportMatch;

    public function getCollectByConditions(array $condition): ?Collection;

    public function save(array $properties): ?SportMatch;

    public function update(int $id, array $properties): int;
}
