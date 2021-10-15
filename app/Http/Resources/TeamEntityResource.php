<?php

namespace App\Http\Resources;

use App\Game\Entities\Team;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Team
 */
class TeamEntityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->getName(),
            'score' => $this->getScore(),
        ];
    }
}
