## Comman Team
$teamService = app(\App\Services\TeamService::class);

$teamService->getAll()->toArray();

$teamService->getByConditions([['name', 'nuevoequipo']])

$teamService->save([ 'name' => 'NuevoEquipo', 'goals_for' => 0, 'goals_against' => 0 ])

$teamToUpdate = $teamService->getByConditions([['name', 'nuevoequipo']]);

$teamService->update(5, [ 'goals_for' => 5, 'goals_against' => 2]);


## Comand Sport Match
$sportMatchService = app(\App\Services\SportMatchService::class)

$sportMatchService->getAll()->toArray()

$sportMatchService->getByConditions([['id', '1']])

$sportMatchService->save([ 'home_team_id' => 3, 'away_team_id' => 1, 'played_at' => "2025-11-01T23:08:01.000000Z" ])

$sportMatchService->update(3, [ 'home_score' => 5, 'away_score' => 2])
