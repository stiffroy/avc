<?php

namespace App\Http\Controllers;

use App\Entity\Group;

class ChartController extends Controller
{
    public function getChart(Group $group)
    {
        dump($group);
    }
}
