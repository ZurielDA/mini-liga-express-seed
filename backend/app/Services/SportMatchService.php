<?php

namespace App\Services;

use App\Exceptions\AlreadyExistsException;
use App\Interfaces\Repositories\ISportMatchRepository;
use App\Interfaces\Services\ISportMatchService;
use App\Models\SportMatch;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SportMatchService implements ISportMatchService
{
    protected $teamRepository;

    public function __construct(ISportMatchRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function getAll(): Collection
    {
        return $this->teamRepository->getAll();
    }

    public function getByConditions(array $conditions): ?SportMatch
    {
        return $this->teamRepository->getByConditions($conditions);
    }

    public function save(array $properties): ?SportMatch
    {
        $existSportMatch = $this->teamRepository->getByConditions([
            ['home_team_id', $properties['home_team_id']],
            ['away_team_id', $properties['away_team_id']],
            ['played_at', $properties['played_at']],
        ]);

        if ($existSportMatch) {
            throw new AlreadyExistsException('Ya existe un partido con los mismos equipos y el mismo dia.');
        }

        return $this->teamRepository->save($properties);
    }

    public function update(int $id, array $properties): ?SportMatch
    {
        $foundSportMatch = $this->getByConditions([
            ['id', $id],
        ]);

        if (! $foundSportMatch) {
            throw new ModelNotFoundException('El partido no existe.');
        }

        $this->teamRepository->update($foundSportMatch->id, $properties);

        return $foundSportMatch->refresh();
    }
}
