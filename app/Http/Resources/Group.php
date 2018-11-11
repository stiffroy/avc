<?php

namespace App\Http\Resources;

use App\Http\Resources\Client as ClientResource;
use App\Http\Resources\Statistics as StatisticsResource;
use App\Http\Resources\User as UserResource;
use App\Utilities\GroupUtilities;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class Group extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'critical' => $this->critical,
            'warning' => $this->warning,
            'clients' => ClientResource::collection($this->whenLoaded('clients')),
            'users' => UserResource::collection($this->whenLoaded('users')),
            'statistics' => StatisticsResource::collection($this->statistics),
            'created_at' => Carbon::parse($this->created_at)->format('d.m.Y H:i'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d.m.Y H:i'),
        ];

        if (get_class($this->whenLoaded('clients')) !== 'Illuminate\Http\Resources\MissingValue') {
            $data['clients_no'] = GroupUtilities::countClients($this);
            $data['clients_data'] = GroupUtilities::getData($this);
        }

        return $data;
    }
}
