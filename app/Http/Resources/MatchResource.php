<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MatchResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'left_team' => new TeamResource($this->whenLoaded('leftTeam')),
            'left_team_id' => $this->left_team_id,
            'right_team' => new TeamResource($this->whenLoaded('rightTeam')),
            'right_team_id' => $this->right_team_id,
            'left_team_score' => $this->left_team_score,
            'right_team_score' => $this->right_team_score,
            'step_type' => $this->step_type,
            'game_key' => $this->game_key,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
