<?php

namespace App\Interfaces\Services;

use App\Models\SportMatch;
use Illuminate\Database\Eloquent\Collection;

interface ISportMatchService
{
    public function getAll(): Collection;

    public function getByConditions(array $conditions): ?SportMatch;

    public function save(array $properties): ?SportMatch;

    public function update(int $id, array $properties): ?SportMatch;
}
