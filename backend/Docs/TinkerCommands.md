## Comman Team
$teamService = app(\App\Services\TeamService::class);

$teamService->getAll()->toArray();

$teamService->getByConditions([['name', 'nuevoequipo']])

$teamService->save([ 'name' => 'NuevoEquipo', 'goals_for' => 0, 'goals_against' => 0 ])

$teamToUpdate = $teamService->getByConditions([['name', 'nuevoequipo']]);

$teamService->update(5, [ 'goals_for' => 5, 'goals_against' => 2]);
