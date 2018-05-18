<?php

namespace App\Http\Resources;

use App\Http\Resources\Client as ClientResource;
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
        $extraData = GroupUtilities::getData($this->clients);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'critical' => $this->critical,
            'warning' => $this->warning,
            'clients' => ClientResource::collection($this->clients),
            'clients_no' => $extraData['clients'],
            'clients_data' => $extraData['data'],
            'chartConfig' => json_encode($this->makeChart($extraData['data'])),
            'created_at' => Carbon::parse($this->created_at)->format('d.m.Y H:i'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d.m.Y H:i'),
        ];
    }

    private function makeChart($data)
    {
        return [
            'type' => 'pie',
            'data' => [
                'labels' => ['No records yet', 'Warning', 'Critical', 'Healthy'],
                'datasets' => [
                    [
                        'data' => $data,
                        'backgroundColor' => ['#00c0ef', '#f39c12', '#dd4b39', '#00a65a'],
                        'hoverBackgroundColor' => ['#00a7d0', '#db8b0b', '#d33724', '#008d4c']
                    ]
                ],
                'options' => [
                    'responsive' => true,
                    'maintainAspectRatio' => '',
                    'legend' => [
                        'position' => 'bottom',
                        'display' => true
                    ]
                ]
            ],
        ];
    }
}
