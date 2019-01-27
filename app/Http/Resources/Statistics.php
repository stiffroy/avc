<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Statistics extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'group_identifier' => $this->group_identifier,
            'subgroup_identifier' => $this->subgroup_identifier,
            'stats' => json_decode($this->data),
            'created_at' => Carbon::parse($this->created_at)->format('d.m.Y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d.m.Y'),
        ];
    }
}
