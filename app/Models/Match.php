<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Match extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'left_team_id',
        'right_team_id',
        'left_team_score',
        'right_team_score',
        'step_type',
        'game_key',
    ];

    public function leftTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'left_team_id');
    }

    public function rightTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'right_team_id');
    }
}
