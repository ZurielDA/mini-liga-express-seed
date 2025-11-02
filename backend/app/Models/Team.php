<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'goals_for',
        'goals_against',
    ];

    protected $appends = [
        'played'
    ];

    /**
     * Get all of the homeSoportMatches for the Team
     */
    public function homeSoportMatches(): HasMany
    {
        return $this->hasMany(SportMatch::class, 'home_team_id');
    }

    /**
     * Get all of the awayMatches for the Team
     */
    public function awayMatches(): HasMany
    {
        return $this->hasMany(SportMatch::class, 'away_team_id');
    }

    public function getPlayedAttribute(): int
    {
        $homePlayed = $this->homeSoportMatches()->whereNotNull('home_score')->whereNotNull('away_score')->count();
        $awayPlayed = $this->awayMatches()->whereNotNull('home_score')->whereNotNull('away_score')->count();

        return $homePlayed + $awayPlayed;
    }
}
