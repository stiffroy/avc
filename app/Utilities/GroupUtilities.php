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
            $getData = self::getData($group->clients);
            $formattedGroup[] = [
                'id' => $group->id,
                'name' => $group->name,
                'critical' => $group->critical,
                'warning' => $group->warning,
                'clients' => $getData['clients'],
                'data' => $getData['data'],
            ];
        }

        return $formattedGroup;
    }

    /**
     * @param $clients
     * @return array
     */
    public static function getData($clients)
    {
        $na = $warning = $critical = $healthy = 0;
        $clients = $clients->map(function ($data) {
            if ($data->alive) {
                return $data;
            }
        });

        foreach ($clients as $client) {
            if ($client->health === ClientUtilities::NO_RECORDS_YET) {
                $na++;
            } elseif ($client->health === ClientUtilities::WARNING) {
                $warning++;
            } elseif ($client->health === ClientUtilities::CRITICAL) {
                $critical++;
            } elseif ($client->health === ClientUtilities::HEALTHY) {
                $healthy++;
            }
        }

        return [
            'clients' => count($clients),
            'data'    => [$na, $warning, $critical, $healthy]
        ];
    }
}
