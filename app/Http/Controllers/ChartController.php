<?php

namespace App\Http\Controllers;

use App\Entity\Group;
use App\Http\Resources\Statistics as StatisticsResource;

class ChartController extends Controller
{
    public function getChart($groupId)
    {
        $group = Group::find($groupId);
        return StatisticsResource::collection($group->statistics);
    }
}
