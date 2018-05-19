<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Client extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $group = [
            'value' => $this->group->id,
            'label' => $this->group->name,
        ];

        return [
            'id' => $this->id,
            'name' => $this->name,
            'external_id' => $this->external_id,
            'api_token' => $this->api_token,
            'alive' => $this->alive,
            'group' => $group,
            'status_label' => $this->statusLabel,
            'bg' => $this->bg,
            'bg_icon' => $this->bgIcon,
            'health' => $this->health,
            'created_at' => Carbon::parse($this->created_at)->format('d.m.Y H:i'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d.m.Y H:i'),
        ];
    }
}
