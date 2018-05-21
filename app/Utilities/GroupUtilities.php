<?php

namespace App\Utilities;

use Illuminate\Database\Eloquent\Collection;

class GroupUtilities
{
    /**
     * @param Collection $groups
     * @return array
     */
    public static function formatData(Collection $groups)
    {
        $formattedGroup = [];
        foreach ($groups as $group) {
            $formattedGroup[] = [
                'id' => $group->id,
                'name' => $group->name,
                'critical' => $group->critical,
                'warning' => $group->warning,
                'clients' => $group->clients->count(),
                'data' => self::getData($group),
            ];
        }

        return $formattedGroup;
    }

    /**
     * @param $group
     * @return array
     */
    public static function getData($group)
    {
        $na = $warning = $critical = $healthy = 0;

        if ($group->clients) {
            foreach ($group->clients as $client) {
                if ($client->alive && $client->health === ClientUtilities::NO_RECORDS_YET) {
                    $na++;
                } elseif ($client->alive && $client->health === ClientUtilities::WARNING) {
                    $warning++;
                } elseif ($client->alive && $client->health === ClientUtilities::CRITICAL) {
                    $critical++;
                } elseif ($client->alive && $client->health === ClientUtilities::HEALTHY) {
                    $healthy++;
                }
            }
        }

        $data = [$na, $warning, $critical, $healthy];

        return $data;
    }

    public static function countClients($group)
    {
        return $group->clients ? $group->clients->count() : 0;
    }
}
