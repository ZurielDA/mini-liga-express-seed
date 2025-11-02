<?php

namespace App\Services;

use App\Exceptions\AlreadyExistsException;
use App\Interfaces\Repositories\ITeamRepository;
use App\Interfaces\Services\ITeamService;
use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
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

        if($id != $properties['id'])
        {
            throw new InvalidArgumentException('No se puede actualizar por que existen propiedades no validas');
        }

        $properties = Arr::except($properties, ['id']);

        $this->teamRepository->update($foundTeam->id, $properties);

        return $foundTeam->refresh();
    }
}
