<?php

namespace App\Services;

use App\Exceptions\AlreadyExistsException;
use App\Interfaces\Repositories\ISportMatchRepository;
use App\Interfaces\Services\ISportMatchService;
use App\Interfaces\Services\ITeamService;
use App\Models\SportMatch;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SportMatchService implements ISportMatchService
{
    protected $sportMatchRepository;

    protected $teamService;

    public function __construct(ISportMatchRepository $sportMatchRepository, ITeamService $teamService)
    {
        $this->sportMatchRepository = $sportMatchRepository;
        $this->teamService = $teamService;
    }

    public function getAll(): Collection
    {
        return $this->sportMatchRepository->getAll();
    }

    public function getByConditions(array $conditions): ?SportMatch
    {
        return $this->sportMatchRepository->getByConditions($conditions);
    }

    public function save(array $properties): ?SportMatch
    {
        $existSportMatch = $this->sportMatchRepository->getByConditions([
            ['home_team_id', $properties['home_team_id']],
            ['away_team_id', $properties['away_team_id']],
            ['played_at', $properties['played_at']],
        ]);

        if ($existSportMatch) {
            throw new AlreadyExistsException('Ya existe un partido con los mismos equipos y el mismo dia.');
        }

        return $this->sportMatchRepository->save($properties);
    }

    public function update(int $id, array $properties): ?SportMatch
    {
        $foundSportMatch = $this->getByConditions([
            ['id', $id],
        ]);

        if (! $foundSportMatch) {
            throw new ModelNotFoundException('El partido no existe.');
        }

        $this->sportMatchRepository->update($foundSportMatch->id, $properties);

        $foundSportMatch->refresh();

        $this->teamService->addGoals(
            $foundSportMatch->home_team_id,
            $foundSportMatch->home_score,
            $foundSportMatch->away_team_id,
            $foundSportMatch->away_score,
        );

        return $foundSportMatch;
    }
}
