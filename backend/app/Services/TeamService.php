<?php

namespace App\Services;

use App\Exceptions\AlreadyExistsException;
use App\Interfaces\Repositories\ITeamRepository;
use App\Interfaces\Services\ITeamService;
use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use InvalidArgumentException;

class TeamService implements ITeamService
{
    protected $teamRepository;

    public function __construct(ITeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function getAll(): Collection
    {
        return $this->teamRepository->getAll();
    }

    public function getByConditions(array $conditions): ?Team
    {
        return $this->teamRepository->getByConditions($conditions);
    }

    public function save(array $properties): ?Team
    {
        $properties['name'] = Str::lower($properties['name']);

        $existTeam = $this->teamRepository->getByConditions([
            ['name', $properties['name']],
        ]);

        if ($existTeam) {
            throw new AlreadyExistsException("El equipo '{$properties['name']}' ya existe.");
        }

        return $this->teamRepository->save($properties);
    }

    public function update(int $id, array $properties): ?Team
    {
        $foundTeam = $this->getByConditions([
            ['id', $id],
        ]);

        if (! $foundTeam) {
            throw new ModelNotFoundException('El equipo no existe.');
        }

        if ($id != $properties['id']) {
            throw new InvalidArgumentException('No se puede actualizar por que existen propiedades no validas');
        }

        $properties = Arr::except($properties, ['id']);

        $this->teamRepository->update($foundTeam->id, $properties);

        return $foundTeam->refresh();
    }

    public function addGoals(int $home_team_id, int $home_score, int $away_team_id, int $away_score): void
    {
        $home_team = $this->getByConditions([['id', $home_team_id]]);

        $home_team->goals_for += $home_score;
        $home_team->goals_against += $away_score;

        $this->update($home_team->id, [
            'id' => $home_team->id,
            'goals_for' => $home_team->goals_for,
            'goals_against' => $home_team->goals_against,
        ]);

        $away_team = $this->getByConditions([['id', $away_team_id]]);

        $away_team->goals_for += $away_score;
        $away_team->goals_against += $home_score;

        $this->update($away_team->id, [
            'id' => $away_team->id,
            'goals_for' => $away_team->goals_for,
            'goals_against' => $away_team->goals_against,
        ]);
    }
}
