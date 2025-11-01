<?php

namespace Database\Seeders;

use App\Models\SportMatch;
use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamsAndSportMatchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = collect(['Dragons', 'Sharks', 'Tigers', 'Wolves'])
            ->map(fn ($n) => Team::create(['name' => $n]));

        // crea 2-3 partidos sin resultado
        SportMatch::create([
            'home_team_id' => $teams[0]->id, 'away_team_id' => $teams[1]->id,
        ]);
        SportMatch::create([
            'home_team_id' => $teams[2]->id, 'away_team_id' => $teams[3]->id,
        ]);
    }
}
