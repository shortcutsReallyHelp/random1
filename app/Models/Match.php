<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
}
