<?php

namespace App\Http\Resources;

use App\Http\Resources\Group as GroupResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'api_token' => $this->api_token,
            'slack_webhook_url' => $this->slack_webhook_url,
            'preferred_method' => $this->preferred_method,
            'groups' => GroupResource::collection($this->whenLoaded('groups')),
            'created_at' => Carbon::parse($this->created_at)->format('d.m.Y H:i'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d.m.Y H:i'),
        ];
    }
}
