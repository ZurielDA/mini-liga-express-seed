<?php

namespace Tests\Feature;

use App\Interfaces\Services\ISportMatchService;
use App\Interfaces\Services\IStandingsService;
use App\Interfaces\Services\ITeamService;
use App\Models\Team;
use Tests\TestCase;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StandingsTest extends TestCase
{
    use RefreshDatabase;

    protected $teamService;
    protected $sportMatchService;
    protected $standingsService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->teamService = app(ITeamService::class);
        $this->sportMatchService = app(ISportMatchService::class);
        $this->standingsService = app(IStandingsService::class);
    }

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $expectedClassification = collect([
            ['team' => 'Tigers',    'played' => 4, 'point' => 7,  'goals_for' => 10, 'goals_against' => 7,  'goal_diff' => 3 ],
            ['team' => 'Quetzales', 'played' => 3, 'point' => 6,  'goals_for' => 11, 'goals_against' => 8,  'goal_diff' => 3 ],
            ['team' => 'Dragons',   'played' => 4, 'point' => 5,  'goals_for' => 12, 'goals_against' => 11, 'goal_diff' => 1 ],
            ['team' => 'Tezcatix',  'played' => 4, 'point' => 5,  'goals_for' => 11, 'goals_against' => 13, 'goal_diff' => -2 ],
            ['team' => 'Sharks',    'played' => 4, 'point' => 3,  'goals_for' => 8,  'goals_against' => 12, 'goal_diff' => -4 ],
            ['team' => 'Wolves',    'played' => 5, 'point' => 6,  'goals_for' => 14, 'goals_against' => 15, 'goal_diff' => -1 ],
        ]);


        $matches = collect([
            ['local' => 'Dragons',   'goles_local' => 4, 'visitante' => 'Sharks',    'goles_visitante' => 2, 'match' => null],
            ['local' => 'Tigers',    'goles_local' => 3, 'visitante' => 'Wolves',    'goles_visitante' => 3, 'match' => null],
            ['local' => 'Tezcatix',  'goles_local' => 2, 'visitante' => 'Quetzales', 'goles_visitante' => 5, 'match' => null],
            ['local' => 'Dragons',   'goles_local' => 1, 'visitante' => 'Tigers',    'goles_visitante' => 2, 'match' => null],
            ['local' => 'Sharks',    'goles_local' => 3, 'visitante' => 'Wolves',    'goles_visitante' => 1, 'match' => null],
            ['local' => 'Tezcatix',  'goles_local' => 4, 'visitante' => 'Dragons',   'goles_visitante' => 4, 'match' => null],
            ['local' => 'Sharks',    'goles_local' => 2, 'visitante' => 'Tezcatix',  'goles_visitante' => 3, 'match' => null],
            ['local' => 'Tigers',    'goles_local' => 1, 'visitante' => 'Quetzales', 'goles_visitante' => 2, 'match' => null],
            ['local' => 'Wolves',    'goles_local' => 5, 'visitante' => 'Quetzales', 'goles_visitante' => 4, 'match' => null],
            ['local' => 'Dragons',   'goles_local' => 3, 'visitante' => 'Wolves',    'goles_visitante' => 3, 'match' => null],
            ['local' => 'Sharks',    'goles_local' => 1, 'visitante' => 'Tigers',    'goles_visitante' => 4, 'match' => null],
            ['local' => 'Tezcatix',  'goles_local' => 2, 'visitante' => 'Wolves',    'goles_visitante' => 2, 'match' => null],
        ]);

        $teams = collect(['Dragons', 'Sharks', 'Tigers', 'Wolves', 'Tezcatix', 'Quetzales'])->map(fn ($n) => $this->teamService->save(['name' => $n]));

        $matches = $matches->map(function ($sportMatch, int $key) use ($teams)
        {
            $home_team =  $teams->first(function (Team $value, int $key) use ($sportMatch){
                return Str::lower($value->name) == Str::lower($sportMatch['local']);
            });

            $away_team =  $teams->first(function (Team $value, int $key) use ($sportMatch){
                return Str::lower($value->name) == Str::lower($sportMatch['visitante']);
            });

            $sportMatch['match'] = $this->sportMatchService->save([
                'home_team_id' => $home_team->id,
                'away_team_id'=> $away_team->id,
                'played_at'=>  Carbon::now()->subDays(rand(0, 30)),
            ]);

            return $sportMatch;
        });

        $matches->each(function ($sportMatch, int $key)
        {
            $this->sportMatchService->update($sportMatch['match']['id'], [
                'home_score' => $sportMatch['goles_local'],
                'away_score' => $sportMatch['goles_visitante']
            ]);
        });

        $standings = $this->standingsService->get();

        $expectedClassification->each(function ($expectedTeam) use ($standings)
        {
            $team = Arr::first($standings, function ($value, int $key) use($expectedTeam)
            {
                return Str::lower($value['team']) == Str::lower($expectedTeam['team']);
            });

            $this->assertNotNull($team, "El equipo {$expectedTeam['team']} debería existir en los standings");

            $this->assertEquals($expectedTeam['played'],      $team['played'],      "Partidos jugados incorrectos para {$expectedTeam['team']}");
            $this->assertEquals($expectedTeam['point'],       $team['point'],       "Puntos incorrectos para {$expectedTeam['team']}");
            $this->assertEquals($expectedTeam['goals_for'],   $team['goals_for'],   "Goles a favor incorrectos para {$expectedTeam['team']}");
            $this->assertEquals($expectedTeam['goals_against'],$team['goals_against'], "Goles en contra incorrectos para {$expectedTeam['team']}");
            $this->assertEquals($expectedTeam['goal_diff'],   $team['goal_diff'],   "Diferencia de goles incorrecta para {$expectedTeam['team']}");
        });


        $response->assertStatus(200);
    }
}
