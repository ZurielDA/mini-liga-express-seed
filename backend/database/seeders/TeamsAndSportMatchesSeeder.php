<?php

namespace Database\Seeders;

use App\Interfaces\Services\ITeamService;
use App\Models\SportMatch;
use App\Models\Team;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class TeamsAndSportMatchesSeeder extends Seeder
{
    protected $teamService;

    public function __construct(ITeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = new Faker;

        $teams = collect(['Dragons', 'Sharks', 'Tigers', 'Wolves', 'Tezcatix', 'Quetzales'])->map(fn ($n) => Team::create(['name' => $n]));

        $teams->each(function (Team $team, int $key) use ($faker, $teams) {
            $awayTeam = $teams->where('id', '!=', $team->id)->random();

            $home_team = SportMatch::create([
                'home_team_id' => $team->id,
                'away_team_id' => $awayTeam->id,
                'home_score' => $faker->numberBetween(0, 9),
                'away_score' => $faker->numberBetween(0, 9),
                'played_at' => Carbon::now()->subDays($faker->numberBetween(0, 10)),
            ]);

            $this->teamService->addGoals(
                $home_team->home_team_id,
                $home_team->home_score,
                $home_team->away_team_id,
                $home_team->away_score,
            );

            $away_team = SportMatch::create([
                'home_team_id' => $awayTeam->id,
                'away_team_id' => $team->id,
                'home_score' => $faker->numberBetween(0, 9),
                'away_score' => $faker->numberBetween(0, 9),
                'played_at' => Carbon::now()->subDays($faker->numberBetween(0, 10)),
            ]);

            $this->teamService->addGoals(
                $away_team->home_team_id,
                $away_team->home_score,
                $away_team->away_team_id,
                $away_team->away_score,
            );
        });
    }
}
